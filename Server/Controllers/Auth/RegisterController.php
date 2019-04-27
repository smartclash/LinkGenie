<?php

namespace Server\Controllers\Auth;


use Server\Controllers\Controller;

class RegisterController extends Controller
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
        return $this->view($res, 'Auth/Register');
    }

    /**
     * @param \Slim\Http\Request  $req
     * @param \Slim\Http\Response $res
     * @param array               $args
     *
     * @return int
     */
    public function register($req, $res, $args = [])
    {
        try {
            return $this->auth->register(
                $req->getParam('email'), $req->getParam('password'), null,
                function ($selector, $token) use ($req, $res) {
                    $this->mail->addAddress($req->getParam('email'));
                    $this->mail->isHTML(true);

                    $this->mail->Subject = 'Vasty - Verify Your Email Address';
                    $this->mail->Body = $this->view->fetch('Auth/Email/Verify.twig', [
                        'selector' => urlencode($selector),
                        'token' => urlencode($token)
                    ]);

                    $this->mail->send();

                    return $res->getBody()->write('<h1>Sent you an email</h1>');
                }
            );
        } catch (\Delight\Auth\InvalidEmailException $e) {
            die('Invalid email address');
        } catch (\Delight\Auth\InvalidPasswordException $e) {
            die('Invalid password');
        } catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('User already exists');
        } catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        } catch (\Delight\Auth\AuthError $e) {
            die('Auth error. LOL');
        }
    }
}
