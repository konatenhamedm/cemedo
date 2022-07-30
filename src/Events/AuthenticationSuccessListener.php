<?php


namespace App\Events;
use App\Repository\AdresseRepository;
use App\Repository\AffectionRepository;
use App\Repository\AssuranceRepository;
use App\Repository\AssureRepository;
use App\Repository\FactureRepository;
use App\Repository\FichierMedicalRepository;
use App\Repository\LivraisonRepository;
use App\Repository\MedecinRepository;
use App\Repository\MedicamentRepository;
use App\Repository\MembreFamilleRepository;
use App\Repository\OrdonnanceRepository;
use App\Repository\PageCarnetSanteRepository;
use App\Repository\PatientRepository;
use App\Repository\RendezVousRepository;
use App\Repository\ServiceRepository;
use App\Repository\TypeFichierMedicalRepository;
use App\Repository\TypeMedecinRepository;
use App\Repository\TypeServiceRepository;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;


class AuthenticationSuccessListener
{
    private $adresseRepository;
    private $user;
    private $assure;
    private $factureRepository;
    private $medecinRepository;
    private $affectionRepository;
    private $assuranceRepository;
    private $membreFamilleRepository;
    private $patientRepository;
    private $serviceRepository;
    private $ordonnanceRepository;
    private $medicamentRepository;
    private $typeFichierMedicalRepository;
    private $typeMedecinRepository;
    private $typeServiceRepository;
    private $pageCarnetSanteRepository;
    private $livraison;
    private $rendezVous;

    public function __construct(
        AdresseRepository $adresseRepository,
        MedecinRepository $medecinRepository,
        FactureRepository $factureRepository,
        AffectionRepository $affectionRepository,
        AssuranceRepository $assuranceRepository,
        MembreFamilleRepository $membreFamilleRepository
        ,PatientRepository $patientRepository,
        ServiceRepository $serviceRepository,
        OrdonnanceRepository $ordonnanceRepository,
         MedicamentRepository $medicamentRepository,
        TypeFichierMedicalRepository $typeFichierMedicalRepository,
        FichierMedicalRepository $fichierMedicalRepository
        ,TypeMedecinRepository $typeMedecinRepository,
        TypeServiceRepository $typeServiceRepository,
        PageCarnetSanteRepository $pageCarnetSanteRepository,
    LivraisonRepository $livraison,
        RendezVousRepository $rendezVous,
    UserRepository $user,
    AssureRepository $assure
    )
    {
                $this->rendezVous=$rendezVous;
                $this->user=$user;
                $this->assure=$assure;
                $this->livraison=$livraison;
                $this->adresseRepository=$adresseRepository;
                $this->factureRepository=$factureRepository;
                $this->medecinRepository=$medecinRepository;
                $this->affectionRepository=$affectionRepository;
                $this->assuranceRepository=$assuranceRepository;
                $this->membreFamilleRepository=$membreFamilleRepository;
                $this->patientRepository=$patientRepository;
                $this->serviceRepository=$serviceRepository;
                $this->ordonnanceRepository=$ordonnanceRepository;
                $this->medicamentRepository=$medicamentRepository;
                $this->typeFichierMedicalRepository=$typeFichierMedicalRepository;
                $this->typeMedecinRepository=$typeMedecinRepository;
                $this->typeServiceRepository=$typeServiceRepository;
                $this->pageCarnetSanteRepository=$pageCarnetSanteRepository;
    }

    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();
//dd($user);
        if (!$user instanceof UserInterface) {
            return;
        }
        $arrayFacture = array();
        foreach ($this->factureRepository->findBy(['assure'=>$user]) as $patient){
            $arrayFacture [] = array(
                'id'=>$patient->getId(),
                'libelle'=>$patient->getLibelle(),
                'montant'=>$patient->getMontant(),
                'date_emission'=>$patient->getDateEmission(),
            );
        }

        $arrayFamille = array();
        foreach ($this->membreFamilleRepository->findBy(['assure'=>$user]) as $patient){
            $arrayFamille [] = array(
                'id'=>$patient->getId(),
                'nom'=>$patient->getNom(),
                'prenom'=>$patient->getPrenoms(),
                'tel'=>$patient->getTel(),
                'tel2'=>$patient->getTel2(),
            );
        }
        $arrayPatient = array();

        foreach ($this->patientRepository->findAll() as $patient){
            $arrayPatient [] = array(
                'id'=>$patient->getId(),
                'nom'=>$patient->getNom(),
                'prenom'=>$patient->getPrenoms(),
                'tel'=>$patient->getTel(),
                'tel2'=>$patient->getTel2(),
            );
        }

        $arrayAdresse = array();
        foreach ($this->adresseRepository->findBy(['assure'=>$user]) as $patient){
            $arrayAdresse [] = array(
                'id'=>$patient->getId(),
                'libelle'=>$patient->getLibelle(),
                'active'=>$patient->isActive(),
            );
        }
        $arrayAllAffection = array();
        foreach ($this->affectionRepository->findAll() as $patient){
            $arrayAllAffection [] = array(
                'id'=>$patient->getId(),
                'libelle'=>$patient->getLibelle(),
                'value'=>$patient->getValue(),
                'active'=>$patient->isActive(),
            );
        }

        $arrayAffection = array();
        foreach ($this->affectionRepository->findBy(['assure'=>$user]) as $patient){
            $arrayAffection [] = array(
                'id'=>$patient->getId(),
                'libelle'=>$patient->getLibelle(),
                'value'=>$patient->getValue(),
                'active'=>$patient->isActive(),
            );
        }
        $arrayAllAssurance = array();
        foreach ($this->assuranceRepository->findAll() as $patient){
            $arrayAllAssurance [] = array(
                'id'=>$patient->getId(),
                'libelle'=>$patient->getLibelle(),
                'active'=>$patient->isActive(),
            );
        }
        $arrayAllService = array();

        foreach ($this->serviceRepository->getServices() as $patient){
            $arrayAllService [] = array(
                'id'=>$patient['id'],
                'libelle'=>$patient['libelle'],
                'description'=>$patient['description'],
                'active'=>$patient['active'],
                'typeService'=>[
                    'id'=>$patient['typeServiceId'],
                    'libelle'=>$patient['typeService']
                ],
            );
        }

        $arrayMedicament = array();
        foreach ($this->medicamentRepository->findAll() as $patient){
            $arrayMedicament [] = array(
                'id'=>$patient->getId(),
                'libelle'=>$patient->getLibelle(),
                'active'=>$patient->isActive(),
            );
        }
         $arrayOrdonnance = array();
        foreach ($this->ordonnanceRepository->findBy(['assure'=>$user]) as $patient){
            $arrayOrdonnance [] = array(
                'id'=>$patient->getId(),
                'libelle'=>$patient->getLibelle(),
                'active'=>$patient->isActive(),
            );
        }

        $arrayLivraison= array();
        foreach ($this->livraison->findBy(['assure'=>$user]) as $patient){
            $arrayLivraison [] = array(
                'id'=>$patient->getId(),
                'date_livraison'=>$patient->getDateLivraison(),
                'etat'=>$patient->getEtat(),
                'active'=>$patient->isActive(),
            );
        }
//dd($this->rendezVous->findBy(['concerne'=>$user]));
        $arrayRendezVous= array();
        foreach ($this->rendezVous->findBy(['concerne'=>$user]) as $patient){
            //dd($patient->getGerant()->getNom());
            $arrayRendezVous [] = array(
                'id'=>$patient->getId(),
                'gerant'=>[
                    'id'=>$patient->getGerant()->getId(),
                    'nom'=>$this->user->findOneBy(['id'=>$patient->getGerant()->getId()])->getNom(),
                    'prenoms'=>$this->user->findOneBy(['id'=>$patient->getGerant()->getId()])->getPrenoms(),
                ],
                'emetteur'=>[
                    'id'=>$patient->getEmetteur()->getId(),
                    'nom'=>$this->assure->findOneBy(['id'=>$patient->getEmetteur()->getId()])->getNom(),
                    'prenoms'=>$this->assure->findOneBy(['id'=>$patient->getEmetteur()->getId()])->getPrenoms(),
                ],
                'medecin'=>[
                    'id'=>$patient->getMedecin()->getId(),
                    'nom'=>$this->user->findOneBy(['id'=>$patient->getMedecin()->getId()])->getNom(),
                    'prenoms'=>$this->user->findOneBy(['id'=>$patient->getMedecin()->getId()])->getPrenoms(),
                ],
                'service'=>[
                    'id'=>$patient->getService()->getId(),
                    'libelle'=>$this->serviceRepository->findOneBy(['id'=>$patient->getService()->getId()])->getLibelle()
                ],
                'adresse'=>[
                    'id'=>$patient->getAdresse()->getId(),
                    'libelle'=>$this->adresseRepository->findOneBy(['id'=>$patient->getAdresse()->getId()])->getLibelle()
                ],
                'active'=>$patient->isActive(),
            );
        }
        // dd($arrayService);
       /* $arrayTypeService = array();
        foreach ($typeServiceRepository->findAll() as $patient){
            $arrayTypeService [] = array(
                'id'=>$patient->getId(),
                'libelle'=>$patient->getLibelle(),
                'active'=>$patient->isActive(),
            );
        }
        $arrayTypeMedecin = array();
        foreach ($typeMedecinRepository->findAll() as $patient){
            $arrayTypeMedecin [] = array(
                'id'=>$patient->getId(),
                'libelle'=>$patient->getLibelle(),
                'active'=>$patient->isActive(),
            );
        }
        $arrayTypeFichier = array();
        foreach ($typeFichierMedicalRepository->findAll() as $patient){
            $arrayTypeFichier [] = array(
                'id'=>$patient->getId(),
                'libelle'=>$patient->getLibelle(),
                'active'=>$patient->isActive(),
            );
        }


        $arrayPageCarnet = array();
        foreach ($pageCarnetSanteRepository->findAll() as $patient){
            $arrayPageCarnet [] = array(
                'id'=>$patient->getId(),
                'lien'=>$patient->getLienFichier(),
                'active'=>$patient->isActive(),
            );
        }
        $arrayFichierMedical = array();
        foreach ($fichierMedicalRepository->findAll() as $patient){
            $arrayFichierMedical [] = array(
                'id'=>$patient->getId(),
                'libelle'=>$patient->getLibelle(),
                'active'=>$patient->isActive(),
            );
        }

        $arrayMedecin = array();
        foreach ($medecinRepository->findAll() as $patient){
            $arrayMedecin [] = array(
                'id'=>$patient->getId(),
                'nom'=>$patient->getNom(),
                'prenoms'=>$patient->getPrenoms(),
                'specialite'=>$patient->getSepecialiteMedecin(),
                'active'=>$patient->isActive(),
            );
        }*/

        $data['data'] = array(
            'id'=>$user->getId(),
            'nom'=>$user->getNom(),
            'prenoms'=>$user->getPrenoms(),
            'tel'=>$user->getTel(),
            'email'=>$user->getEmail(),
            'tel2'=>$user->getTel2(),
            'password'=>$user->getPassword(),
            'sexe'=>$user->getSexe(),
            'fcmtoken'=>$user->getFcmtoken(),
            'tauxCouverture'=>$user->getTauxCouverture(),
            'autreAntecedent'=>$user->getAutreAntecedent(),
            'numeroAssure'=>$user->getNumeroAssure(),
            'lieuHabitation'=>$user->getLieuHabitation(),
            'dateNaissance'=>$user->getDateNaissance(),
            'createdAt'=>$user->getCreatedAt(),
            'updatedAt'=>$user->getUpdatedAt(),
            'version'=>$user->getVersion(),
            'active'=>$user->isActive(),
            'profession'=>$user->getProfession(),
            'pieceIdRecto'=>$user->getPieceIdRecto(),
            'pieceIdVerso'=>$user->getPieceIdVerso(),
            'assuranceRecto'=>$user->getAssuranceRecto(),
            'assuranceVerso'=>$user->getAssuranceVerso(),
            'roles' => $user->getRoles(),
            'familles'=> $arrayFamille,
            'affections'=> $arrayAffection,
            'all_affections'=> $arrayAllAffection,
            'all_services'=> $arrayAllService,
            'factures'=> $arrayFacture,
            'ordonnances'=> $arrayOrdonnance,
            'adresses'=> $arrayAdresse,
            'rendez_vous'=> $arrayRendezVous,
        );

        $event->setData($data);
    }
}