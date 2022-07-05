<?php
 namespace App\Events;

 use App\Repository\AffectionRepository;
 use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

 class JwtSubscriber {

     private $repository;
     public function __construct(AffectionRepository $repository)
     {
         $this->repository = $repository;
     }

     public function updateJwtData(JWTCreatedEvent $event){
         $user = $event->getUser() ;

         $data = $event->getData();

         $data['firstName'] = $user->getFirstName();
         $data['lastName'] = $user->getLastName();
         $data['telephone1'] = $user->getTelephone1();
         $data['lieuHabitation'] = $user->getLieuHabitation();
         $data['fcmtoken'] = $user->getFcmtoken();
         $data['affections'] = $this->repository->findOneBySomeField($user);
         $data['status'] = 200;
         $event->setData($data);
     /* dd($event->getData());*/
     }
 }