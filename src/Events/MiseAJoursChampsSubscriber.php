<?php


namespace App\Events;



use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Media;
use App\Entity\Patient;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class MiseAJoursChampsSubscriber implements EventSubscriberInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [ 'setUpdateFields',EventPriorities::PRE_VALIDATE]
        ];
    }
    public function setUpdateFields(ViewEvent $event){
        $increment = 0;
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
//dd($event);
      //  if (!($entity instanceof Patient)){
           if ($method ==="POST" && !str_contains($event->getRequest()->getPathInfo(),"update")){
               $entity->setCreatedAt(new \DateTime('now'));
               $entity->setUpdatedAt(new \DateTime('now'));
               $entity->setActive(true);
               $entity->setVersion($increment);
           }elseif ($method ==="PUT"){
               $entity->setUpdatedAt(new \DateTime('now'));
               $entity->setVersion($entity->getVersion()+1);
           }elseif ($method === "POST" && str_contains($event->getRequest()->getPathInfo(),"update")){
               $entity->setUpdatedAt(new \DateTime('now'));
               $entity->setVersion($entity->getVersion()+1);
           }
          }



  //  }
}