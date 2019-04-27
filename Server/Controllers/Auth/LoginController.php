<?php

namespace Server\Controllers\Auth;


use Server\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * @param \Slim\Http\Request  $req
     * @param \Slim\Http\Response $res
     * @param array               $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show($req, $res, $args = [])
    {
        return $this->view($res, 'Auth/Login');
    }

    /**
     * @param \Slim\Http\Request  $req
     * @param \Slim\Http\Response $res
     * @param array               $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function login($req, $res, $args = [])
    {
        try {
            return $this->auth->login($req->getParam('email'), $req->getParam('password'));
        } catch (\Delight\Auth\InvalidEmailException $e) {
            die('Wrong email address');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Wrong password');
        } catch (\Delight\Auth\EmailNotVerifiedException $e) {
            die('Email not verified');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        } catch (\Delight\Auth\AuthError $e) {
            die('Auth error. LOL');
        } catch(\Delight\Auth\AttemptCancelledException $e) {
            die('Auth error. LOL');
        }
    }
}
