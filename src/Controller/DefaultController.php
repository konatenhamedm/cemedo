<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Administrateur;
use App\Entity\Assure;
use App\Entity\Gerant;
use App\Entity\Infirmier;
use App\Entity\Medecin;
use App\Entity\Patient;
use App\Entity\Pharmacien;
use App\Entity\User;
use App\Repository\AssuranceRepository;
use App\Repository\GerantRepository;
use App\Repository\PatientRepository;
use App\Repository\TypeMedecinRepository;
use App\Repository\UserRepository;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DefaultController
{
    private $manager;
    private $encoder;
    private $security;
    private $repo;
    private $repository;

    public function __construct(AssuranceRepository $repo,TypeMedecinRepository $repository, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder, Security $security)
    {
        $this->manager = $manager;
        $this->encoder = $encoder;
        $this->security = $security;
        $this->repo = $repo;
        $this->repository = $repository;

    }

    public function __invoke(UserRepository $repository,PatientRepository $patientRepository,Request $request, FileUploader $fileUploader)
    {
        //dd($repository->find($request->attributes->get('id')));
        if ($request->attributes->get('_api_resource_class') === "App\Entity\Patient"){
            $entity = $patientRepository->find($request->attributes->get('id'));

            $pieceIdRecto = $request->files->get('pieceIdRecto');
            $pieceIdVerso = $request->files->get('pieceIdVerso');
            $assuranceRecto = $request->files->get('assuranceRecto');
            $assuranceVerso = $request->files->get('assuranceVerso');

            if ($request->request->get("password"))
                $hash = $this->encoder->hashPassword(new Assure(), $request->request->get("password"));

            if ($pieceIdRecto)
                $entity->setPieceIdRecto($fileUploader->upload($pieceIdRecto));
            if ($pieceIdVerso)
                $entity->setPieceIdVerso($fileUploader->upload($pieceIdVerso));
            if ($assuranceRecto)
                $entity->setAssuranceRecto($fileUploader->upload($assuranceRecto));
            if ($assuranceVerso)
                $entity->setAssuranceVerso($fileUploader->upload($assuranceVerso));
            if ($request->request->get("tel"))
                $entity->setTel($request->request->get("tel"));
            if ($request->request->get("tel2"))
                $entity->setTel2($request->request->get("tel2"));
            if ($request->request->get("password"))
                $entity->setPassword($hash);
            if ($request->request->get("nom"))
                $entity->setNom($request->request->get("nom"));
            if ($request->request->get("assurance"))
                $entity->setAssurance($this->repo->find($request->request->get("assurance")));
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
        }else{
            $entity = $repository->find($request->attributes->get('id'));
            $photo = $request->files->get('photo');
//dd($photo);
            if ($request->request->get("password"))
                $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));
            // dd($entity);
            if ($request->request->get("password"))
                $entity->setPassword($hashs);
            if ($photo)
                $entity->setPhoto($fileUploader->upload($photo));
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
                    $entity->setPrimeMedecin($request->request->get("primeMedecin"));
                if ($request->request->get("salaireMedecin"))
                    $entity->setSalaireMedecin($request->request->get("salaireMedecin"));
                if ($request->request->get("specialiteMedecin"))
                    $entity->setSepecialiteMedecin($request->request->get("specialiteMedecin"));
                if ($request->request->get("typeMedecin"))
                    $entity->setTypeMedecin($this->repository->find($request->request->get("typeMedecin")));
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
     * @param FileUploader $fileUploader
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function newPatient(Request $request, FileUploader $fileUploader, EntityManagerInterface $entityManager)
    {
        $response = new Response();
        $pieceIdRecto = $request->files->get('pieceIdRecto');
        $pieceIdVerso = $request->files->get('pieceIdVerso');
        $assuranceRecto = $request->files->get('assuranceRecto');
        $assuranceVerso = $request->files->get('assuranceVerso');

        //file = new File('1-62d02b59c31f1.png');


        $entity = new Patient();

        $hash = $this->encoder->hashPassword(new Assure(), $request->request->get("password"));

        if ($pieceIdRecto)
            $entity->setPieceIdRecto($fileUploader->upload($pieceIdRecto));
        if ($pieceIdVerso)
            $entity->setPieceIdVerso($fileUploader->upload($pieceIdVerso));
        if ($assuranceRecto)
            $entity->setAssuranceRecto($fileUploader->upload($assuranceRecto));
        if ($assuranceVerso)
            $entity->setAssuranceVerso($fileUploader->upload($assuranceVerso));

        $entity->setTel($request->request->get("tel"));
        $entity->setTel2($request->request->get("tel2"));
        $entity->setPassword($hash);
        $entity->setNom($request->request->get("nom"));
        $entity->setAssurance($this->repo->find($request->request->get("assurance")));
        $entity->setPrenoms($request->request->get("prenoms"));
        $entity->setEmail($request->request->get("email"));
        $entity->setSexe($request->request->get("sexe"));
        $entity->setFcmtoken($request->request->get("fcmtoken"));
        $entity->setTauxCouverture(floatval($request->request->get("tauxCouverture")));
        $entity->setAutreAntecedent($request->request->get("autreAntecedent"));
        $entity->setNumeroAssure($request->request->get("numeroAssure"));
        $entity->setLieuHabitation($request->request->get("lieuHabitation"));
       /* $entity->setCreatedAt(new \DateTime('now'));
        $entity->setActive(true);
        $entity->setVersion(0);*/
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
        $photo = $request->files->get('photo');
        $entity = new Administrateur();

        $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));

        if ($request->request->get("password"))
            $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));
        // dd($entity);
        if ($request->request->get("password"))
            $entity->setPassword($hashs);
        if ($photo)
            $entity->setPhoto($fileUploader->upload($photo));
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
        $photo = $request->files->get('photo');
        $entity = new Gerant();

        $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));

        if ($request->request->get("password"))
            $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));
        // dd($entity);
        if ($request->request->get("password"))
            $entity->setPassword($hashs);
        if ($photo)
            $entity->setPhoto($fileUploader->upload($photo));
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
     * @Route("/cemedo/pharmaciens", name="pharmacien", methods={"post"})
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function newPharmacien(Request $request, FileUploader $fileUploader, EntityManagerInterface $entityManager)
    {
        $response = new Response();
        $photo = $request->files->get('photo');
        $entity = new Pharmacien();

        $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));

        if ($request->request->get("password"))
            $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));
        // dd($entity);
        if ($request->request->get("password"))
            $entity->setPassword($hashs);
        if ($photo)
            $entity->setPhoto($fileUploader->upload($photo));
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
        $photo = $request->files->get('photo');
        $entity = new Infirmier();

        $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));

        if ($request->request->get("password"))
            $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));
        // dd($entity);
        if ($request->request->get("password"))
            $entity->setPassword($hashs);
        if ($photo)
            $entity->setPhoto($fileUploader->upload($photo));
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
            $entity->setSalaireInfirmier($request->request->get("salaireInfirmier"));
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
        $photo = $request->files->get('photo');
        $entity = new Medecin();

        $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));

        if ($request->request->get("password"))
            $hashs = $this->encoder->hashPassword(new User(), $request->request->get("password"));
        // dd($entity);
        if ($request->request->get("password"))
            $entity->setPassword($hashs);
        if ($photo)
            $entity->setPhoto($fileUploader->upload($photo));
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
            $entity->setPrimeMedecin($request->request->get("primeMedecin"));
        if ($request->request->get("salaireMedecin"))
            $entity->setSalaireMedecin($request->request->get("salaireMedecin"));
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
}
