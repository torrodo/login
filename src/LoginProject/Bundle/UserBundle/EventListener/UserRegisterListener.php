<?php

namespace LoginProject\Bundle\UserBundle\EventListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use LoginProject\Bundle\UserBundle\Entity\User;

/**
 * UserRegisterListener.
 */
class UserRegisterListener
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
     * Get list of subscribed events.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return ['onPrePersist', 'onPostPersist'];
    }

    /**
     * Execute before entity persist.
     *
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $user = $args->getObject();

        // md5 password
        $user->setPassword(
            md5($user->getPassword())
        );

        // birthday is considered from 00:00:00 on that day
        $user->setAgeStatus(
            strtotime('-18 years') >= strtotime($user->getBirthday()->format('Y-m-d')) ?
                User::OVERAGE :
                User::UNDERAGE
        );

        // bonus column just to know when registered
        $user->setCreatedAt(new \DateTime('now'));
    }

    /**
     * Execute after entity persist.
     *
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $user = $args->getObject();
        $welcomeText =
            $this->container
                ->get('templating')
                ->render(
                    'LoginProjectUserBundle:Emails:welcome.html.twig',
                    ['name' => $user->getUsername()]
                );

        $message =
            \Swift_Message::newInstance()
                ->setSubject('Welcome Email')
                ->setFrom('admin@login_project.com', 'admin')
                ->setTo($user->getEmail())
                ->setBody($welcomeText, 'text/html');

        //$this->container->get('mailer')->send($message);
    }
}
