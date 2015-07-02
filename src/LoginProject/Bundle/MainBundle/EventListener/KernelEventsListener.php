<?php

namespace LoginProject\Bundle\MainBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

class KernelEventsListener
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Called by the request event.
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {//var_dump($this->container->get('security.context')->getToken()->getUser());die;
        // $token = $this->container->get('session')->get('_security_default');
        // if (null !== $token) {
        //     $this->container->get('main.auth.manager')->setToken(unserialize($token));
        // }
    }

    /**
     * Called when an uncaught exceptions thrown.
     *
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if ($event->getException() instanceof AuthenticationException) {
            // $url = $this->container->get('router')->generate('login_user_page');
            // $response = new RedirectResponse($url);
            // $event->setResponse($response);
        }
    }
}
