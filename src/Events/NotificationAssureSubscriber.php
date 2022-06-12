<?php


namespace App\Events;



use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Notification;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class NotificationAssureSubscriber implements EventSubscriberInterface
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

        if ($notification instanceof Notification && $method ==="POST"){

            $notification->setPatient($user);
        }

    }
}