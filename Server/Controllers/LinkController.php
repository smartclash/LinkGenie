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
    public function show($req, $res, $args)
    {
        return $this->view($res, 'Link');
    }

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
            return $this->view($res, 'Link', [
                'url' => $this->redis->get($args['code'])
            ]);
        }

        $data = $this->db->select('links', [
            'url',
            'deleted'
        ], [
            'code' => $args['code']
        ])[0];

        if (! $data['deleted']) {
            $this->redis->set($args['code'], $data['url']);

            return $this->view($res, 'Link', [
                'url' => $data['url']
            ]);
        }

        // TODO: Design a "link deleted" page to notify users.
        return $res;
    }
}
