<?php

namespace Server\Controllers;


/**
 * Class Controller
 *
 * @package Server\Controllers
 *
 * @property \Medoo\Medoo                   $db    returns Medoo ORM instance
 * @property \Slim\Views\Twig               $view  returns Twig view instance
 * @property \Predis\Client                 $redis returns Predis instance
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
     * @param  \Psr\Http\Message\ResponseInterface $response
     * @param  string                              $template Template pathname relative to templates directory
     * @param  array                               $data     Associative array of template variables
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function view($response, $template, $data = [])
    {
        return $this->view->render($response, $template . '.twig', $data);
    }
}
