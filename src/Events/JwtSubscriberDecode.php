<?php
namespace App\Events;

use App\Repository\AffectionRepository;
use App\Repository\AssureRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;

class JwtSubscriberDecode {

// src/App/EventListener/JWTCreatedListener.php


    /**
     * @var RequestStack
     */
    private $requestStack;
    private $userRepository;
    /**
     * @param RequestStack $requestStack
     */
    public function __construct(RequestStack $requestStack,AssureRepository $userRepository)
    {
        $this->requestStack = $requestStack;
        $this->userRepository = $userRepository;
    }


    /**
     * @param JWTDecodedEvent $event
     *
     * @return void
     */
    public function onJWTDecoded(JWTDecodedEvent $event)
    {
        $payload = $event->getPayload();
        $user = $this->userRepository->findOneByUsername($payload['tel']);

        $payload['custom_user_data'] = $user->getCustomUserInformations();

        $event->setPayload($payload); // Don't forget to regive the payload for next event / step
    }
}