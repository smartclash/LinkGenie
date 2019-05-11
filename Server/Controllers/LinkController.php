<?php

namespace Server\Controllers;


class LinkController extends Controller
{
    /**
     * @param \Slim\Http\Request  $req
     * @param \Slim\Http\Response $res
     * @param array               $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function newLink($req, $res, $args)
    {
        if (! $req->getParsedBody()['url']) {
            return $res->withStatus(501)->withJson([
                'message' => 'You did not enter a link'
            ]);
        }

        $code = substr(md5(sha1(time() . rand(0, 9999))), 0, 5);

        $this->db->insert('links', [
            'url' => $req->getParsedBody()['url'],
            'code' => $code
        ]);

        return $res->withJson([
            'code' => $code
        ]);
    }

    /**
     * @param \Slim\Http\Request  $req
     * @param \Slim\Http\Response $res
     * @param array               $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getLink($req, $res, $args)
    {
        if ($this->redis->get($args['code'])) {
            if ($this->redis->get($args['code']) === 'deleted') {
                return $this->view($res, 'Links/Deleted');
            }

            return $this->view($res, 'Links/Link', [
                'url' => $this->redis->get($args['code'])
            ]);
        }

        $data = $this->db->select('links', [
            'url',
            'deleted'
        ], [
            'code' => $args['code']
        ]);

        // If there exists a link with that code...
        if ($data) {
            // ...And the code is not deleted, then...
            if (! $data[0]['deleted']) {
                $this->redis->set($args['code'], $data[0]['url']);

                return $this->view($res, 'Links/Link', [
                    'url' => $data[0]['url']
                ]);
            }

            $this->redis->set($args['code'], 'deleted');

            return $this->view($res, 'Links/Deleted');
        }

        return $this->view($res, 'Unknown')->withStatus(404);
    }

    /**
     * @param \Slim\Http\Request  $req
     * @param \Slim\Http\Response $res
     * @param array               $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getLinkS2U($req, $res, $args)
    {
        return $this->view($res, 'Links/Link', [
            'url' => 'https://sub2unlock.com/' . $args['code']
        ]);
    }
}
