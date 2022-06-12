<?php


namespace App\Events;



use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Notification;
use App\Entity\RendezVous;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class RendezVousUtilisateurSubscriber implements EventSubscriberInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [ 'setUserForCustomer',EventPriorities::PRE_VALIDATE]
        ];
    }
    public function setUserForCustomer(ViewEvent $event){

        $user = $this->security->getUser();
        $notification = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($notification instanceof RendezVous && $method ==="POST"){

            $notification->setEmetteur($user);
        }

    }
}