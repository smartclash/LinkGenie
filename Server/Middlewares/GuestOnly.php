<?php

namespace Server\Middlewares;

/**
 * Middleware to allow only Guest users view pages
 *
 * @package Server\Middlewares
 *
 * @property \Medoo\Medoo $db returns Medoo ORM instance
 * @property \PHPMailer\PHPMailer\PHPMailer $mail returns PHPMailer instance
 * @property \Delight\Auth\Auth $auth returns Delight Auth instance
 * @property \Slim\Views\Twig $view returns Twig view instance
 */
class GuestOnly
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * @param  \Slim\Http\Request  $request  SlimPHP request
     * @param  \Slim\Http\Response $response SlimPHP response
     * @param  callable            $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        if($this->auth->isLoggedIn()) {
            return $response->withRedirect('/user/dashboard');
        }

        return $next($request, $response);
    }

    public function __get($property)
    {
        if($this->container->{$property})
            return $this->container->{$property};

        return null;
    }
}
