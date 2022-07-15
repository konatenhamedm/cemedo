<?php
declare(strict_types=1);
namespace App\Controller;


use App\Entity\Administrateur;
use App\Entity\Assure;
use App\Entity\Media;
use App\Entity\Patient;
use App\Entity\User;
use App\Repository\AssureRepository;
use App\Repository\PatientRepository;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MembreFamilleRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;

class DefaultController 
{
    private $manager;
    private $encoder;
    private $security;

    public function __construct(EntityManagerInterface $manager,UserPasswordHasherInterface $encoder,Security $security){
        $this->manager = $manager;
        $this->encoder = $encoder;
        $this->security = $security;
    }
    public function __invoke(Request $request,FileUploader $fileUploader)
    {  $pieceIdRecto = $request->files->get('pieceIdRecto');
       $pieceIdVerso = $request->files->get('pieceIdVerso');

        //file = new File('1-62d02b59c31f1.png');
//dd($request->files);
if ($request->attributes->get('_api_resource_class') === "App\Entity\Patient" ){


        $superhero = new Patient();
       // $hash = $this->encoder->hashPassword(new Assure() ,'achi');
        $superhero->setPieceIdRecto($fileUploader->upload($pieceIdRecto));
        $superhero->setPieceIdVerso($fileUploader->upload($pieceIdVerso));
      /*  $superhero->setCreatedAt(new \DateTime('now'));
        $superhero->setTel("825597850");
        $superhero->setPassword($hash);
        $superhero->setNom('konatenh');
        $superhero->setPrenoms('valy');
        $superhero->setEmail("konatenha@gmail.com");
        $superhero->setSexe("M");
        $superhero->setFcmtoken("M");
        $superhero->setTauxCouverture(3);
        $superhero->setAutreAntecedent("rrrr");
        $superhero->setNumeroAssure("numero_assure");
        $superhero->setLieuHabitation("lieu_habitation");
        $superhero->setUpdatedAt(new \DateTime('now'));
        $superhero->setActive(true);*/
    }

        return $superhero;

    }

    /**
     * @Route("/ced/test", name="test", methods={"GET"})
     */
    public function apiAction(){
        $response = new Response();

        $date = new \DateTime();

        $response->setContent(json_encode([
            'id' => uniqid(),
            'time' => $date->format("Y-m-d")
        ]));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
