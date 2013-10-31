<?php

namespace Encore\CustomerBundle\EventListener;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistrationSuccessListener implements EventSubscriberInterface
{

    private $router;

    function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return [FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess'];
    }

    public function onRegistrationSuccess(FormEvent $event)
    {
        $url = $this->router->generate("encore_registration_success");
        $event->setResponse(new RedirectResponse($url));
    }
} 