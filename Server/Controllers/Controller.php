<?php

namespace Server\Controllers;


use Psr\Http\Message\ResponseInterface;

/**
 * Class Controller
 *
 * @package Server\Controllers
 *
 * @property \Medoo\Medoo                   $db   returns Medoo ORM instance
 * @property \PHPMailer\PHPMailer\PHPMailer $mail returns PHPMailer instance
 * @property \Delight\Auth\Auth             $auth returns Delight Auth instance
 * @property \Slim\Views\Twig               $view returns Twig view instance
 */
class Controller
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function __get($property)
    {
        if($this->container->{$property})
            return $this->container->{$property};

        return null;
    }

    /**
     * Output rendered template
     *
     * @param  ResponseInterface $response
     * @param  string            $template Template pathname relative to templates directory
     * @param  array             $data     Associative array of template variables
     * @return ResponseInterface
     */
    protected function view(ResponseInterface $response, $template, $data = [])
    {
        return $this->view->render($response, $template . '.twig', $data);
    }
}
