<?php

/**
 * Created by PhpStorm.
 * User: lionel
 * Date: 02/03/2016
 * Time: 12:47
 */

namespace UserBundle\EventListener;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class RegistrationConfirmListener implements EventSubscriberInterface
{
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router =$router;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationConfirm',
        );
    }

    public function onRegistrationConfirm(FormEvent $event)
    {
        $url = $this->router->generate('message');
        $event->setResponse(new RedirectResponse($url));
    }
}
