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
use App\Repository\AssuranceRepository;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

class NotificationAssureSubscriber implements EventSubscriberInterface
{
    private $security;
    private $fileUpload;
    private $manager;
    private $encoder;
    private $repo;

    public function __construct(Security $security,FileUploader $fileUpload,AssuranceRepository $repo,EntityManagerInterface $manager,UserPasswordHasherInterface $encoder)
    {
        $this->security = $security;
        $this->fileUpload = $fileUpload;
        $this->manager = $manager;
        $this->encoder = $encoder;
        $this->repo = $repo;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [ 'setUserForCustomer',EventPriorities::PRE_VALIDATE],
           //RequestEvent::class => [ 'onKernelRequest',EventPriorities::PRE_VALIDATE],
        ];
    }
  /*  public function onKernelRequest(RequestEvent $event)
    {//dd($event->getRequest()->files->get('pieceIdRecto'));
        $user = $this->security->getUser();
        $pieceIdRecto = $event->getRequest()->files->get('pieceIdRecto');
        $pieceIdVerso = $event->getRequest()->files->get('pieceIdVerso');
        $assuranceRecto = $event->getRequest()->files->get('assuranceRecto');
        $assuranceVerso = $event->getRequest()->files->get('assuranceVerso');
        if ($event->getRequest()->getPathInfo() === "/cemedo/patients" && $event->getRequest()->getMethod() === "post"){

            $superhero = new Patient();
            $hash = $this->encoder->hashPassword($user,$event->getRequest()->files->get("password"));
            $superhero->setPieceIdRecto($pieceIdRecto->upload($pieceIdRecto));
            $superhero->setPieceIdVerso($pieceIdVerso->upload($pieceIdVerso));
            $superhero->setAssuranceRecto($assuranceRecto->upload($assuranceRecto));
            $superhero->setAssuranceVerso($assuranceVerso->upload($assuranceVerso));
            $superhero->setTel($event->getRequest()->request->get('resquest'));
            $superhero->setTel2($event->getRequest()->request->get("tel2"));
            $superhero->setPassword($hash);
            $superhero->setNom($event->getRequest()->request->get("nom"));
            $superhero->setAssurance($this->repo->find($event->getRequest()->request->get("assurance")));
            $superhero->setPrenoms($event->getRequest()->request->get("prenoms"));
            $superhero->setEmail($event->getRequest()->request->get("email"));
            $superhero->setSexe($event->getRequest()->request->get("sexe"));
            $superhero->setFcmtoken($event->getRequest()->request->get("fcmtoken"));
            $superhero->setTauxCouverture(floatval($event->getRequest()->request->get("tauxCouverture")));
            $superhero->setAutreAntecedent($event->getRequest()->request->get("autreAntecedent"));
            $superhero->setNumeroAssure($event->getRequest()->request->get("numeroAssure"));
            $superhero->setLieuHabitation($event->getRequest()->request->get("lieuHabitation"));
            $superhero->setCreatedAt(new \DateTime('now'));
            $superhero->setUpdatedAt(new \DateTime('now'));
            $superhero->setActive(true);
            $superhero->setVersion(0);
            $this->manager->persist($superhero);
            $this->manager->flush();
            //return $superhero;
        }

        //;

    }*/
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