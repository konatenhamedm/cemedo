<?php
 namespace App\Events;

 use App\Repository\AffectionRepository;
 use App\Repository\AssureRepository;
 use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
 use Symfony\Component\HttpFoundation\RequestStack;
 use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;

 class JwtSubscriber {

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

     public function updateJwtData(JWTCreatedEvent $event){
        /* $user = $event->getUser() ;

         $data = $event->getData();

         $data['nom'] = $user->getNom();
         $data['prenoms'] = $user->getPrenoms();
         $data['tel'] = $user->getTel();
         $data['email'] = $user->getEmail();
         $data['status'] = 200;
         $event->setData($data);
      //dd($event->getData());*/

         $request = $this->requestStack->getCurrentRequest();
         $expiration = new \DateTime('+60 day');
         $expiration->setTime(2, 0, 0);

         $payload       = $event->getData();
         $payload['ip'] = $request->getClientIp();
         $payload['exp'] = $expiration->getTimestamp();


         $event->setData($payload);

         $header        = $event->getHeader();
         $header['cty'] = 'JWT';

         $event->setHeader($header);
     }

 }