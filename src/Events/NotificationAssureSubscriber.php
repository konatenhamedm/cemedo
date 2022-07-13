<?php


namespace App\Events;



use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Administrateur;
use App\Entity\Gerant;
use App\Entity\Infirmier;
use App\Entity\Medecin;
use App\Entity\MembreFamille;
use App\Entity\Notification;
use App\Entity\Patient;
use App\Entity\Pharmacien;
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
        $element = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($element instanceof Notification && $method ==="POST"){
           // dd($element);
            $element->setPatient($user);
        }
        if ($element instanceof Administrateur && $method ==="POST"){
            //dd($element);
            $element->setRoles(array("ROLE_ADMIN"));
        }elseif ($element instanceof Medecin && $method ==="POST"){
            $element->setRoles(array("ROLE_MEDECIN"));
        }
        elseif ($element instanceof Infirmier && $method ==="POST"){
            $element->setRoles(array("ROLE_INFIRMIER"));
        }
        elseif ($element instanceof Pharmacien && $method ==="POST"){
            $element->setRoles(array("ROLE_PHARMACIEN"));
        }
        elseif ($element instanceof Gerant && $method ==="POST"){
            $element->setRoles(array("ROLE_GERANT"));
        }
        elseif ($element instanceof Patient && $method ==="POST"){
            $element->setRoles(array("ROLE_PATIENT"));
        }
        elseif ($element instanceof MembreFamille && $method ==="POST"){
            $element->setRoles(array("ROLE_FAMILLE"));
        }


    }
}