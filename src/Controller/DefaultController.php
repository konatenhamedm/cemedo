<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Administrateur;
use App\Entity\Affection;
use App\Entity\Assure;
use App\Entity\Comptable;
use App\Entity\Gerant;
use App\Entity\Infirmier;
use App\Entity\Medecin;
use App\Entity\Media;
use App\Entity\MembreFamille;
use App\Entity\PageCarnetSante;
use App\Entity\Patient;
use App\Entity\Pharmacien;
use App\Entity\User;
use App\Repository\AdresseRepository;
use App\Repository\AffectionRepository;
use App\Repository\AssuranceRepository;
use App\Repository\AssureRepository;
use App\Repository\FactureRepository;
use App\Repository\FichierMedicalRepository;
use App\Repository\MedecinRepository;
use App\Repository\MediaRepository;
use App\Repository\MedicamentRepository;
use App\Repository\MembreFamilleRepository;
use App\Repository\OrdonnanceRepository;
use App\Repository\PageCarnetSanteRepository;
use App\Repository\PatientRepository;
use App\Repository\ServiceRepository;
use App\Repository\TypeFichierMedicalRepository;
use App\Repository\TypeMedecinRepository;
use App\Repository\TypeServiceRepository;
use App\Repository\UserRepository;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class DefaultController
{
    private $manager;
    private $encoder;
    private $security;
    private $repo;
    private $repository;

    public function __construct(AssuranceRepository $repo,PageCarnetSanteRepository $pageCarnetSanteRepository,TypeMedecinRepository $repository, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder, Security $security)
    {
        $this->manager = $manager;
        $this->encoder = $encoder;
        $this->security = $security;
        $this->repo = $repo;
        $this->repository = $repository;

    }

    public function __invoke(AffectionRepository $affectionRepository,MediaRepository $mediaRepository,UserRepository $repository,PageCarnetSanteRepository $pageCarnetSanteRepository,PatientRepository $patientRepository,MembreFamilleRepository $membreFamilleRepository,Request $request, FileUploader $fileUploader)
    {
       // dd();
        if ($request->attributes->get('_api_resource_class') === "App\Entity\Affection"){
            $entity = $affectionRepository->find($request->attributes->get('id'));

            $etat = $entity->getValue();

            dd($etat);

        }

        if ($request->attributes->get('_api_resource_class') === "App\Entity\Media"){
            $entity = $mediaRepository->find($request->attributes->get('id'));

            //$file = $request->files->get('file');

            if($request->files->get('file'))
                $entity->setFile($request->files->get('file'));
            if ($request->request->get("titre"))
                $entity->setTitre($request->request->get("titre"));
        }elseif ($request->attributes->get('_api_resource_class') === "App\Entity\PageCarnetSante"){
            $entity = $pageCarnetSanteRepository->find($request->attributes->get('id'));

            //$file = $request->files->get('file');

            if($request->files->get('file'))
                $entity->setFile($request->files->get('file'));
           /* if ($request->request->get("titre"))
                $entity->setTitre($request->request->get("titre"));*/
        }
        elseif  ($request->attributes->get('_api_resource_class') === "App\Entity\Patient" ||
            $request->attributes->get('_api_resource_class') === "App\Entity\MembreFamille"){
            if ( $request->attributes->get('_api_resource_class') === "App\Entity\Patient"){
                $entity = $patientRepository->find($request->attributes->get('id'));
            }else{
                $entity = $membreFamilleRepository->find($request->attributes->get('id'));
            }


            $pieceIdRecto = $request->files->get('pieceIdRecto');
            $pieceIdVerso = $request->files->get('pieceIdVerso');
            $assuranceRecto = $request->files->get('assuranceRecto');
            $assuranceVerso = $request->files->get('assuranceVerso');

            if ($pieceIdRecto)
                $entity->setFile($pieceIdRecto);
            if ($pieceIdVerso)
                $entity->setFilePieceVerso($pieceIdVerso);
            if ($assuranceRecto)
                $entity->setFileAssuranceRecto($assuranceRecto);
            if ($assuranceVerso)
                $entity->setFileAssuranceVerso($assuranceVerso);
//dd($entity->getPassword());
            if ($request->request->get("tel"))
                $entity->setTel($request->request->get("tel"));
            if ($request->request->get("tel2"))
                $entity->setTel2($request->request->get("tel2"));
            if ($request->request->get("password") === null){
                return "";
            }else{
                $entity->setPassword($this->encoder->hashPassword(new Assure(), $request->request->get("password")));
            }

            if ($request->request->get("nom"))
                $entity->setNom($request->request->get("nom"));
            /*if ($request->request->get("assurance"))
                $entity->setAssurance($this->repo->find($request->request->get("assurance")));*/
            if ($request->request->get("autreAntecedent"))
                $entity->setAutreAntecedent($request->request->get("autreAntecedent"));
            if ($request->request->get("prenoms"))
                $entity->setPrenoms($request->request->get("prenoms"));
            if ($request->request->get("email"))
                $entity->setEmail($request->request->get("email"));
            if ($request->request->get("dateNaissance"))
                $entity->setDateNaissance(\DateTime::createFromFormat('Y-m-d', $request->request->get("dateNaissance")));
            if ($request->request->get("sexe"))
                $entity->setSexe($request->request->get("sexe"));
            if ($request->request->get("fcmtoken"))
                $entity->setFcmtoken($request->request->get("fcmtoken"));
            if ($request->request->get("tauxCouverture"))
                $entity->setTauxCouverture(floatval($request->request->get("tauxCouverture")));
            if ($request->request->get("autreAntecedent"))
                $entity->setAutreAntecedent($request->request->get("autreAntecedent"));
            if ($request->request->get("numeroAssure"))
                $entity->setNumeroAssure($request->request->get("numeroAssure"));
            if ($request->request->get("lieuHabitation"))
                $entity->setLieuHabitation($request->request->get("lieuHabitation"));
            if ($request->request->get("profession"))
                $entity->setProfession($request->request->get("profession"));

            if ($request->attributes->get('_api_resource_class') === "App\Entity\MembreFamille"){
                if ($request->request->get("relation"))
                    $entity->setRelation($request->request->get("relation"));
            }
        }elseif ($request->attributes->get('_api_resource_class') === "App\Entity\PageCarnetSante"){
            $entity = $pageCarnetSanteRepository->find($request->attributes->get('id'));
            $lieFichier = $request->files->get('lieFichier');
            $user = $this->security->getUser();

            if ($lieFichier)
                $entity->setLienFichier($fileUploader->upload($lieFichier));

            $entity->setAssure($user);

        }
        else{
            $entity = $repository->find($request->attributes->get('id'));

            if($request->files->get('file'))
                $entity->setFile($request->files->get('file'));

            if ($request->request->get("password"))
                $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));
            // dd($entity);
            if ($request->request->get("password"))
                $entity->setPassword($hashs);

            if ($request->request->get("nom"))
                $entity->setNom($request->request->get("nom"));
            if ($request->request->get("prenoms"))
                $entity->setPrenoms($request->request->get("prenoms"));
            if ($request->request->get("email"))
                $entity->setEmail($request->request->get("email"));
            if ($request->request->get("tel"))
                $entity->setTel($request->request->get("tel"));
            if ($request->request->get("dateNaissance"))
                $entity->setDateNaissance(\DateTime::createFromFormat('Y-m-d', $request->request->get("dateNaissance")));
            if ($request->request->get("genre"))
                $entity->setGenre($request->request->get("genre"));
            if ($request->request->get("numeroCni"))
                $entity->setNumeroCni($request->request->get("numeroCni"));
            if ($request->request->get("residence"))
                $entity->setResidence($request->request->get("residence"));

            if ($request->attributes->get('_api_resource_class') === "App\Entity\Infirmier"){
                if ($request->request->get("salaireInfirmier"))
                    $entity->setSalaireInfirmier($request->request->get("salaireInfirmier"));
            }elseif ($request->attributes->get('_api_resource_class') === "App\Entity\Medecin"){
                if ($request->request->get("primeMedecin"))
                    $entity->setPrimeMedecin(floatval($request->request->get("primeMedecin")));
                if ($request->request->get("salaireMedecin"))
                    $entity->setSalaireMedecin(floatval($request->request->get("salaireMedecin")));
                if ($request->request->get("specialiteMedecin"))
                    $entity->setSepecialiteMedecin($request->request->get("specialiteMedecin"));
               /* if ($request->request->get("typeMedecin"))
                    $entity->setTypeMedecin($this->repository->find($request->request->get("typeMedecin")));*/
                if ($request->request->get("heureDebut"))
                    $entity->setHeureDebut(\DateTime::createFromFormat('Y-m-d', $request->request->get("heureDebut")));
                if ($request->request->get("heureFin"))
                    $entity->setHeureFin(\DateTime::createFromFormat('Y-m-d', $request->request->get("heureFin")));

            }

        }

        return $entity;

    }

    /**
     * @Route("/cemedo/patients", name="test", methods={"post"})
     * @param Request $request
     * @param JWTTokenManagerInterface $JWTManager
     * @param AssureRepository $repository
     * @param FileUploader $fileUploader
     * @param EntityManagerInterface $entityManager
     * @param PatientRepository $patientRepository
     * @return Response
     */
    public function newPatient(Request $request,JWTTokenManagerInterface $JWTManager,
                               AssureRepository $repository, FileUploader $fileUploader, EntityManagerInterface $entityManager,PatientRepository $patientRepository)
    {


        $response = new Response();
        $pieceIdRecto = $request->files->get('pieceIdRecto');
        $pieceIdVerso = $request->files->get('pieceIdVerso');
        $assuranceRecto = $request->files->get('assuranceRecto');
        $assuranceVerso = $request->files->get('assuranceVerso');

        //file = new File('1-62d02b59c31f1.png');


        $entity = new Patient();

        $affections = [
            [
                "key"=>"asthme",
                "libelle"=>"Faites-vous de l'asthme ?",
            ],
            [
                "key"=>"drepanocytose",
                "libelle"=>"Etes-vous drépanocytaire ?",
            ],
            [
                "key"=>"diabete",
                "libelle"=>"Avez-vous la diabète ?",
            ],
            [
                "key"=>"ulcere",
                "libelle"=>"Etes-vous ulcérieux(se) ?",
            ],
            [
                "key"=>"vih",
                "libelle"=>"Avez-vous le VIH/SIDA ?",
            ],
            [
                "key"=>"hepatite",
                "libelle"=>"Avez-vous de l'hépatie ?",
            ],
            [
                "key"=>"insCardiaque",
                "libelle"=>"Avez-vous une insuffisance cardiaque ?",
            ],
            [
                "key"=>"insRenal",
                "libelle"=>"Avez-vous une insuffisance rénale ?",
            ],
            [
                "key"=>"tension",
                "libelle"=>"Etes-vous sujet à des tensions artérielles haute ou base ?",
            ],
            [
                "key"=>"allergies",
                "libelle"=>"Etes-vous sujet à des allergies médicamenteuses et/ou alimentaire ?",
            ],
            [
                "key"=>"articulation",
                "libelle"=>"Avez-vous une maladie liée aux articulations ?",
            ],
            [
                "key"=>"cardiaque",
                "libelle"=>"Avez-vous une maladie cardiaque ?",
            ]

        ];

        $hash = $this->encoder->hashPassword(new Assure(), $request->request->get("password"));

        if ($pieceIdRecto)
            $entity->setFile($pieceIdRecto);
        if ($pieceIdVerso)
            $entity->setFilePieceVerso($pieceIdVerso);
        if ($assuranceRecto)
            $entity->setFileAssuranceRecto($assuranceRecto);
        if ($assuranceVerso)
            $entity->setFileAssuranceVerso($assuranceVerso);

        if ($request->request->get("tel"))
            $entity->setTel($request->request->get("tel"));
        $entity->setTel2($request->request->get("tel2"));
        $entity->setPassword($hash);
        $entity->setNom($request->request->get("nom"));
        $entity->setAssurance($this->repo->find($request->request->get("assurance")));
        $entity->setPrenoms($request->request->get("prenoms"));
        $entity->setEmail($request->request->get("email"));
        $entity->setDateNaissance(\DateTime::createFromFormat('Y-m-d', $request->request->get("dateNaissance")));
        $entity->setSexe($request->request->get("sexe"));
        $entity->setFcmtoken($request->request->get("fcmtoken"));
        $entity->setTauxCouverture(floatval($request->request->get("tauxCouverture")));
        $entity->setAutreAntecedent($request->request->get("autreAntecedent"));
        $entity->setNumeroAssure($request->request->get("numeroAssure"));
        $entity->setLieuHabitation($request->request->get("lieuHabitation"));
        $entity->setProfession($request->request->get("profession"));
        $entity->setRoles(array("ROLE_PATIENT"));
       if ($request->request->get("assurance"))
               $entity->setAssurance($this->repo->find($request->request->get("assurance")));

        $entity->setCreatedAt(new \DateTime('now'));
        $entity->setActive(true);
        $entity->setVersion(0);
        $entityManager->persist($entity);
        $entityManager->flush();

        foreach ($affections as $aft){
            $affection = new Affection();
            $affection->setAssure($entity)
                ->setLibelle($aft['libelle'])
                ->setCle($aft['key'])
                ->setValue(0)
                ->setUpdatedAt(new \DateTime('now'))
                ->setCreatedAt(new \DateTime('now'))
                ->setActive(true)
                ->setVersion(0);

            $entityManager->persist($affection);
            $entityManager->flush();
        }
      //  dd($JWTManager->create($repository->getPatient($patientRepository->getLastPatient())));
        $response->setContent(json_encode([
            'status' => 200,
            'data' => $repository->getPatient($patientRepository->getLastPatient())
        ]));

        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }


    /**
     * @Route("/cemedo/patients", name="test", methods={"post"})
     * @param Request $request
     * @param JWTTokenManagerInterface $JWTManager
     * @param AssureRepository $repository
     * @param FileUploader $fileUploader
     * @param EntityManagerInterface $entityManager
     * @param MembreFamilleRepository $membreFamilleRepository
     * @return Response
     */
    public function newMembre(Request $request,JWTTokenManagerInterface $JWTManager,
                               AssureRepository $repository, FileUploader $fileUploader, EntityManagerInterface $entityManager,MembreFamilleRepository $membreFamilleRepository)
    {


        $response = new Response();
        $pieceIdRecto = $request->files->get('pieceIdRecto');
        $pieceIdVerso = $request->files->get('pieceIdVerso');
        $assuranceRecto = $request->files->get('assuranceRecto');
        $assuranceVerso = $request->files->get('assuranceVerso');

        //file = new File('1-62d02b59c31f1.png');


        $entity = new MembreFamille();

        $affections = [
            [
                "key"=>"asthme",
                "libelle"=>"Faites-vous de l'asthme ?",
            ],
            [
                "key"=>"drepanocytose",
                "libelle"=>"Etes-vous drépanocytaire ?",
            ],
            [
                "key"=>"diabete",
                "libelle"=>"Avez-vous la diabète ?",
            ],
            [
                "key"=>"ulcere",
                "libelle"=>"Etes-vous ulcérieux(se) ?",
            ],
            [
                "key"=>"vih",
                "libelle"=>"Avez-vous le VIH/SIDA ?",
            ],
            [
                "key"=>"hepatite",
                "libelle"=>"Avez-vous de l'hépatie ?",
            ],
            [
                "key"=>"insCardiaque",
                "libelle"=>"Avez-vous une insuffisance cardiaque ?",
            ],
            [
                "key"=>"insRenal",
                "libelle"=>"Avez-vous une insuffisance rénale ?",
            ],
            [
                "key"=>"tension",
                "libelle"=>"Etes-vous sujet à des tensions artérielles haute ou base ?",
            ],
            [
                "key"=>"allergies",
                "libelle"=>"Etes-vous sujet à des allergies médicamenteuses et/ou alimentaire ?",
            ],
            [
                "key"=>"articulation",
                "libelle"=>"Avez-vous une maladie liée aux articulations ?",
            ],
            [
                "key"=>"cardiaque",
                "libelle"=>"Avez-vous une maladie cardiaque ?",
            ]

        ];

        $hash = $this->encoder->hashPassword(new Assure(), $request->request->get("password"));

        if ($pieceIdRecto)
            $entity->setFile($pieceIdRecto);
        if ($pieceIdVerso)
            $entity->setFilePieceVerso($pieceIdVerso);
        if ($assuranceRecto)
            $entity->setFileAssuranceRecto($assuranceRecto);
        if ($assuranceVerso)
            $entity->setFileAssuranceVerso($assuranceVerso);

        if ($request->request->get("tel"))
            $entity->setTel($request->request->get("tel"));
        $entity->setTel2($request->request->get("tel2"));
        $entity->setPassword($hash);
        $entity->setNom($request->request->get("nom"));
        $entity->setAssurance($this->repo->find($request->request->get("assurance")));
        $entity->setPrenoms($request->request->get("prenoms"));
        $entity->setEmail($request->request->get("email"));
        $entity->setDateNaissance(\DateTime::createFromFormat('Y-m-d', $request->request->get("dateNaissance")));
        $entity->setSexe($request->request->get("sexe"));
        $entity->setFcmtoken($request->request->get("fcmtoken"));
        $entity->setTauxCouverture(floatval($request->request->get("tauxCouverture")));
        $entity->setAutreAntecedent($request->request->get("autreAntecedent"));
        $entity->setNumeroAssure($request->request->get("numeroAssure"));
        $entity->setLieuHabitation($request->request->get("lieuHabitation"));
        $entity->setProfession($request->request->get("profession"));
        $entity->setRelation($request->request->get("relation"));
        $entity->setRoles(array("ROLE_PATIENT"));
        if ($request->request->get("assurance"))
            $entity->setAssurance($this->repo->find($request->request->get("assurance")));

        $entity->setCreatedAt(new \DateTime('now'));
        $entity->setActive(true);
        $entity->setVersion(0);
        $entityManager->persist($entity);
        $entityManager->flush();

        foreach ($affections as $aft){
            $affection = new Affection();
            $affection->setAssure($entity)
                ->setLibelle($aft['libelle'])
                ->setCle($aft['key'])
                ->setValue(0)
                ->setUpdatedAt(new \DateTime('now'))
                ->setCreatedAt(new \DateTime('now'))
                ->setActive(true)
                ->setVersion(0);

            $entityManager->persist($affection);
            $entityManager->flush();
        }
        //  dd($JWTManager->create($repository->getPatient($patientRepository->getLastPatient())));
        $response->setContent(json_encode([
            'status' => 200,
            'data' => $repository->getMembre($membreFamilleRepository->getLastMembre())
        ]));

        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/cemedo/page_carnet_santes", name="page_carnet_santes", methods={"post"})
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function newPageCarnet(Request $request, FileUploader $fileUploader, EntityManagerInterface $entityManager)
    {
        $response = new Response();
        $file = $request->files->get('file');

        $entity = new PageCarnetSante();

        if ($file)
            $entity->setFile($file);

        $entity->setCreatedAt(new \DateTime('now'));
        $entity->setUpdatedAt(new \DateTime('now'));
        $entity->setActive(true);
        $entity->setVersion(0);
        $entityManager->persist($entity);
        $entityManager->flush();


        $response->setContent(json_encode([
            'status' => 200,
            'data' => "dedicace a mon pote yves"
        ]));

        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }


    /**
     * @Route("/cemedo/administrateurs", name="admin", methods={"post"})
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function newAdministrateur(Request $request, FileUploader $fileUploader, EntityManagerInterface $entityManager)
    {
        $response = new Response();
        $photo = $request->files->get('file');
        $entity = new Administrateur();

        $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));

        if ($request->request->get("password"))
            $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));
        // dd($entity);
        if ($request->request->get("password"))
            $entity->setPassword($hashs);

        if ($photo)
            $entity->setFile($photo);

        if ($request->request->get("nom"))
            $entity->setNom($request->request->get("nom"));
        if ($request->request->get("prenoms"))
            $entity->setPrenoms($request->request->get("prenoms"));
        if ($request->request->get("email"))
            $entity->setEmail($request->request->get("email"));
        if ($request->request->get("tel"))
            $entity->setTel($request->request->get("tel"));
        if ($request->request->get("dateNaissance"))
            $entity->setDateNaissance(\DateTime::createFromFormat('Y-m-d', $request->request->get("dateNaissance")));
        if ($request->request->get("genre"))
            $entity->setGenre($request->request->get("genre"));
        if ($request->request->get("numeroCni"))
            $entity->setNumeroCni($request->request->get("numeroCni"));
        if ($request->request->get("residence"))
            $entity->setResidence($request->request->get("residence"));
        $entity->setRoles(array("ROLE_ADMIN"));
         $entity->setCreatedAt(new \DateTime('now'));
         $entity->setUpdatedAt(new \DateTime('now'));
         $entity->setActive(true);
         $entity->setVersion(0);
        $entityManager->persist($entity);
        $entityManager->flush();


        $response->setContent(json_encode([
            'status' => 200,
            'data' => "dedicace a mon pote yves"
        ]));

        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }


    /**
     * @Route("/cemedo/gerants", name="gerant", methods={"post"})
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function newGerant(Request $request, FileUploader $fileUploader, EntityManagerInterface $entityManager)
    {
        $response = new Response();
        $photo = $request->files->get('file');
        $entity = new Gerant();

        $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));

        if ($request->request->get("password"))
            $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));
        // dd($entity);
        if ($request->request->get("password"))
            $entity->setPassword($hashs);

        if ($photo)
            $entity->setFile($photo);

        if ($request->request->get("nom"))
            $entity->setNom($request->request->get("nom"));
        if ($request->request->get("prenoms"))
            $entity->setPrenoms($request->request->get("prenoms"));
        if ($request->request->get("email"))
            $entity->setEmail($request->request->get("email"));
        if ($request->request->get("tel"))
            $entity->setTel($request->request->get("tel"));
        if ($request->request->get("dateNaissance"))
            $entity->setDateNaissance(\DateTime::createFromFormat('Y-m-d', $request->request->get("dateNaissance")));
        if ($request->request->get("genre"))
            $entity->setGenre($request->request->get("genre"));
        if ($request->request->get("numeroCni"))
            $entity->setNumeroCni($request->request->get("numeroCni"));
        if ($request->request->get("residence"))
            $entity->setResidence($request->request->get("residence"));
        $entity->setRoles(array("ROLE_GERANT"));
        $entity->setCreatedAt(new \DateTime('now'));
        $entity->setUpdatedAt(new \DateTime('now'));
        $entity->setActive(true);
        $entity->setVersion(0);
        $entityManager->persist($entity);
        $entityManager->flush();


        $response->setContent(json_encode([
            'status' => 200,
            'data' => "dedicace a mon pote yves"
        ]));

        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/cemedo/comptables", name="comptable", methods={"post"})
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function newComptable(Request $request, FileUploader $fileUploader, EntityManagerInterface $entityManager)
    {
        $response = new Response();
        $photo = $request->files->get('file');
        $entity = new Comptable();

        $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));

        if ($request->request->get("password"))
            $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));
        // dd($entity);
        if ($request->request->get("password"))
            $entity->setPassword($hashs);

        if ($photo)
            $entity->setFile($photo);

        if ($request->request->get("nom"))
            $entity->setNom($request->request->get("nom"));
        if ($request->request->get("prenoms"))
            $entity->setPrenoms($request->request->get("prenoms"));
        if ($request->request->get("email"))
            $entity->setEmail($request->request->get("email"));
        if ($request->request->get("tel"))
            $entity->setTel($request->request->get("tel"));
        if ($request->request->get("dateNaissance"))
            $entity->setDateNaissance(\DateTime::createFromFormat('Y-m-d', $request->request->get("dateNaissance")));
        if ($request->request->get("genre"))
            $entity->setGenre($request->request->get("genre"));
        if ($request->request->get("numeroCni"))
            $entity->setNumeroCni($request->request->get("numeroCni"));
        if ($request->request->get("residence"))
            $entity->setResidence($request->request->get("residence"));
        $entity->setRoles(array("ROLE_COMPTABLE"));
        $entity->setCreatedAt(new \DateTime('now'));
        $entity->setUpdatedAt(new \DateTime('now'));
        $entity->setActive(true);
        $entity->setVersion(0);
        $entityManager->persist($entity);
        $entityManager->flush();


        $response->setContent(json_encode([
            'status' => 200,
            'data' => "dedicace a mon pote yves"
        ]));

        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }


    /**
     * @Route("/cemedo/pharmaciens", name="pharmacien", methods={"post"})
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function newPharmacien(Request $request, FileUploader $fileUploader, EntityManagerInterface $entityManager)
    {
        $response = new Response();
        $photo = $request->files->get('file');
        $entity = new Pharmacien();

        $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));

        if ($request->request->get("password"))
            $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));
        // dd($entity);
        if ($request->request->get("password"))
            $entity->setPassword($hashs);

        if ($photo)
            $entity->setFile($photo);

        if ($request->request->get("nom"))
            $entity->setNom($request->request->get("nom"));
        if ($request->request->get("prenoms"))
            $entity->setPrenoms($request->request->get("prenoms"));
        if ($request->request->get("email"))
            $entity->setEmail($request->request->get("email"));
        if ($request->request->get("tel"))
            $entity->setTel($request->request->get("tel"));
        if ($request->request->get("dateNaissance"))
            $entity->setDateNaissance(\DateTime::createFromFormat('Y-m-d', $request->request->get("dateNaissance")));
        if ($request->request->get("genre"))
            $entity->setGenre($request->request->get("genre"));
        if ($request->request->get("numeroCni"))
            $entity->setNumeroCni($request->request->get("numeroCni"));
        if ($request->request->get("residence"))
            $entity->setResidence($request->request->get("residence"));
        $entity->setRoles(array("ROLE_PHARMACIEN"));
        $entity->setCreatedAt(new \DateTime('now'));
        $entity->setUpdatedAt(new \DateTime('now'));
        $entity->setActive(true);
        $entity->setVersion(0);
        $entityManager->persist($entity);
        $entityManager->flush();


        $response->setContent(json_encode([
            'status' => 200,
            'data' => "dedicace a mon pote yves"
        ]));

        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }


    /**
     * @Route("/cemedo/infirmiers", name="infirmier", methods={"post"})
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function newInfirmier(Request $request, FileUploader $fileUploader, EntityManagerInterface $entityManager)
    {
        $response = new Response();
        $photo = $request->files->get('file');
        $entity = new Infirmier();

        $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));

        if ($request->request->get("password"))
            $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));
        // dd($entity);
        if ($request->request->get("password"))
            $entity->setPassword($hashs);

        if ($photo)
            $entity->setFile($photo);

        if ($request->request->get("nom"))
            $entity->setNom($request->request->get("nom"));
        if ($request->request->get("prenoms"))
            $entity->setPrenoms($request->request->get("prenoms"));
        if ($request->request->get("email"))
            $entity->setEmail($request->request->get("email"));
        if ($request->request->get("tel"))
            $entity->setTel($request->request->get("tel"));
        if ($request->request->get("dateNaissance"))
            $entity->setDateNaissance(\DateTime::createFromFormat('Y-m-d', $request->request->get("dateNaissance")));
        if ($request->request->get("genre"))
            $entity->setGenre($request->request->get("genre"));
        if ($request->request->get("numeroCni"))
            $entity->setNumeroCni($request->request->get("numeroCni"));
        if ($request->request->get("residence"))
            $entity->setResidence($request->request->get("residence"));
        if ($request->request->get("salaireInfirmier"))
            $entity->setSalaireInfirmier(floatval($request->request->get("salaireInfirmier")));
        $entity->setRoles(array("ROLE_INFIRMIER"));
        $entity->setCreatedAt(new \DateTime('now'));
        $entity->setUpdatedAt(new \DateTime('now'));
        $entity->setActive(true);
        $entity->setVersion(0);
        $entityManager->persist($entity);
        $entityManager->flush();


        $response->setContent(json_encode([
            'status' => 200,
            'data' => "dedicace a mon pote yves"
        ]));

        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/cemedo/medecins", name="medecins", methods={"post"})
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function newMedecin(Request $request, FileUploader $fileUploader, EntityManagerInterface $entityManager)
    {
        $response = new Response();
        $photo = $request->files->get('file');
        $entity = new Medecin();

        $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));

        if ($request->request->get("password"))
            $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));
        // dd($entity);
        if ($request->request->get("password"))
            $entity->setPassword($hashs);
        if ($photo)
            $entity->setFile($photo);

        if ($request->request->get("nom"))
            $entity->setNom($request->request->get("nom"));
        if ($request->request->get("prenoms"))
            $entity->setPrenoms($request->request->get("prenoms"));
        if ($request->request->get("email"))
            $entity->setEmail($request->request->get("email"));
        if ($request->request->get("tel"))
            $entity->setTel($request->request->get("tel"));
        if ($request->request->get("dateNaissance"))
            $entity->setDateNaissance(\DateTime::createFromFormat('Y-m-d', $request->request->get("dateNaissance")));
        if ($request->request->get("genre"))
            $entity->setGenre($request->request->get("genre"));
        if ($request->request->get("numeroCni"))
            $entity->setNumeroCni($request->request->get("numeroCni"));
        if ($request->request->get("residence"))
            $entity->setResidence($request->request->get("residence"));
        if ($request->request->get("primeMedecin"))
            $entity->setPrimeMedecin(floatval($request->request->get("primeMedecin")));
        if ($request->request->get("salaireMedecin"))
            $entity->setSalaireMedecin(floatval($request->request->get("salaireMedecin")));
        if ($request->request->get("specialiteMedecin"))
            $entity->setSepecialiteMedecin($request->request->get("specialiteMedecin"));
        if ($request->request->get("typeMedecin"))
            $entity->setTypeMedecin($this->repository->find($request->request->get("typeMedecin")));
        if ($request->request->get("heureDebut"))
            $entity->setHeureDebut(\DateTime::createFromFormat('Y-m-d', $request->request->get("heureDebut")));
        if ($request->request->get("heureFin"))
            $entity->setHeureFin(\DateTime::createFromFormat('Y-m-d', $request->request->get("heureFin")));
        $entity->setRoles(array("ROLE_MEDECIN"));
        $entity->setCreatedAt(new \DateTime('now'));
        $entity->setUpdatedAt(new \DateTime('now'));
        $entity->setActive(true);
        $entity->setVersion(0);
        $entityManager->persist($entity);
        $entityManager->flush();


        $response->setContent(json_encode([
            'status' => 200,
            'data' => "dedicace a mon pote yves"
        ]));

        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/cemedo/all_object", name="all_object", methods={"post","get"})
     * @param AdresseRepository $adresseRepository
     * @param MedecinRepository $medecinRepository
     * @param FactureRepository $factureRepository
     * @param AffectionRepository $affectionRepository
     * @param AssuranceRepository $assuranceRepository
     * @param MembreFamilleRepository $membreFamilleRepository
     * @param PatientRepository $patientRepository
     * @param ServiceRepository $serviceRepository
     * @param OrdonnanceRepository $ordonnanceRepository
     * @param MedicamentRepository $medicamentRepository
     * @param TypeFichierMedicalRepository $typeFichierMedicalRepository
     * @param FichierMedicalRepository $fichierMedicalRepository
     * @param TypeMedecinRepository $typeMedecinRepository
     * @param TypeServiceRepository $typeServiceRepository
     * @param PageCarnetSanteRepository $pageCarnetSanteRepository
     * @return Response
     */
    public function getALlObject(
    AdresseRepository $adresseRepository,MedecinRepository $medecinRepository,FactureRepository $factureRepository,
    AffectionRepository $affectionRepository,AssuranceRepository $assuranceRepository,MembreFamilleRepository $membreFamilleRepository
    ,PatientRepository $patientRepository,ServiceRepository $serviceRepository,OrdonnanceRepository $ordonnanceRepository,
    MedicamentRepository $medicamentRepository,TypeFichierMedicalRepository $typeFichierMedicalRepository,FichierMedicalRepository $fichierMedicalRepository
    ,TypeMedecinRepository $typeMedecinRepository,TypeServiceRepository $typeServiceRepository,PageCarnetSanteRepository $pageCarnetSanteRepository
    )
{
       $response = new Response();

        $arrayFacture = array();
        foreach ($factureRepository->findAll() as $patient){
            $arrayFacture [] = array(
                'id'=>$patient->getId(),
                'libelle'=>$patient->getLibelle(),
                'montant'=>$patient->getMontant(),
            );
        }

        $arrayFamille = array();
        foreach ($membreFamilleRepository->findAll() as $patient){
            $arrayFamille [] = array(
                'id'=>$patient->getId(),
                'nom'=>$patient->getNom(),
                'prenom'=>$patient->getPrenoms(),
                'tel'=>$patient->getTel(),
                'tel2'=>$patient->getTel2(),
            );
        }
        $arrayPatient = array();

    foreach ($patientRepository->findAll() as $patient){
        $arrayPatient [] = array(
            'id'=>$patient->getId(),
            'nom'=>$patient->getNom(),
            'prenom'=>$patient->getPrenoms(),
            'tel'=>$patient->getTel(),
            'tel2'=>$patient->getTel2(),
        );
    }

    $arrayAdresse = array();
    foreach ($adresseRepository->findAll() as $patient){
        $arrayAdresse [] = array(
            'id'=>$patient->getId(),
            'libelle'=>$patient->getLibelle(),
            'active'=>$patient->isActive(),
        );
    }
    $arrayAffection = array();
    foreach ($affectionRepository->findAll() as $patient){
        $arrayAffection [] = array(
            'id'=>$patient->getId(),
            'libelle'=>$patient->getLibelle(),
            'value'=>$patient->getValue(),
            'active'=>$patient->isActive(),
        );
    }
      $arrayAssurance = array();
    foreach ($assuranceRepository->findAll() as $patient){
        $arrayAssurance [] = array(
            'id'=>$patient->getId(),
            'libelle'=>$patient->getLibelle(),
            'active'=>$patient->isActive(),
        );
    }
      $arrayService = array();

    foreach ($serviceRepository->getServices() as $patient){
        $arrayService [] = array(
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
   // dd($arrayService);
      $arrayTypeService = array();
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
      $arrayOrdonnance = array();
    foreach ($ordonnanceRepository->findAll() as $patient){
        $arrayOrdonnance [] = array(
            'id'=>$patient->getId(),
            'libelle'=>$patient->getLibelle(),
            'active'=>$patient->isActive(),
        );
    }
      $arrayMedicament = array();
    foreach ($medicamentRepository->findAll() as $patient){
        $arrayMedicament [] = array(
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
    }

        $response->setContent(json_encode([
            'status' => 200,
            /*'patients' => $arrayPatient,
            'adresses' => $arrayAdresse,
            'affections' => $arrayAffection,*/
            'assurances' => $arrayAssurance,
            'services' => $arrayService,
            /* 'typeServices' => $arrayTypeService,
           * 'typeMedecins' => $arrayTypeMedecin,
             'typeFichiers' => $arrayTypeFichier,
             'ordonnance' => $arrayOrdonnance,
             'medicament' => $arrayMedicament,
             'pageCarnets' => $arrayPageCarnet,
             'fichierFichierMedicaments' => $arrayFichierMedical,
             'medecins' => $arrayMedecin,
             'factures' => $arrayFacture,
             'familles' => $arrayFamille*/
        ]));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}
