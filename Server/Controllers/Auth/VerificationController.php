<?php

namespace Server\Controllers\Auth;


use Server\Controllers\Controller;

class VerificationController extends Controller
{
    /**
     * @param \Slim\Http\Request  $req
     * @param \Slim\Http\Response $res
     * @param array               $args
     *
     * @return int
     */
    public function show($req, $res, $args = [])
    {
        try {
            $this->auth->confirmEmailAndSignIn($req->getParam('selector'), $req->getParam('token'));

            return $res->getBody()->write('<h1>Your email has been verified and now logged in</h1>');
        } catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        } catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        } catch (\Delight\Auth\AuthError $e) {
            die('Auth Error LOL');
        }
    }
}
