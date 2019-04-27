<?php

namespace Server\Controllers;


class HomeController extends Controller
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
        return $this->view($res, 'Home');
    }
}
