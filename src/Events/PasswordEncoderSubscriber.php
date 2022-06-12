<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Assure;
use App\Entity\User;
use App\Kernel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordEncoderSubscriber implements EventSubscriberInterface
{
   private $encoder;

   public function __construct(UserPasswordHasherInterface $encoder)
   {
       $this->encoder = $encoder;
   }

    public static function getSubscribedEvents()
    {
      return [
          KernelEvents::VIEW => [ 'encodePassword',EventPriorities::PRE_WRITE]
      ];


    }

    public function encodePassword(ViewEvent $event){
    $user = $event->getControllerResult();
    $assure = $event->getControllerResult();
    //dd($user);
    $method = $event->getRequest()->getMethod();

    if($user instanceof User && $method === "POST"){
     $hash = $this->encoder->hashPassword($user ,$user->getPassword());
     $user->setPassword($hash);
    }

        if($assure instanceof Assure && $method === "POST"){
            $hash = $this->encoder->hashPassword($assure ,$assure->getPassword());
            $assure->setPassword($hash);
        }
    }
}