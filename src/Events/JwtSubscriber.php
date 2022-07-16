<?php
 namespace App\Events;

 use App\Repository\AffectionRepository;
 use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

 class JwtSubscriber {


     public function updateJwtData(JWTCreatedEvent $event){
         $user = $event->getUser() ;

         $data = $event->getData();

         $data['nom'] = $user->getNom();
         $data['prenoms'] = $user->getPrenoms();
         $data['tel'] = $user->getTel();
         $data['status'] = 200;
         $event->setData($data);
      //dd($event->getData());
     }
 }