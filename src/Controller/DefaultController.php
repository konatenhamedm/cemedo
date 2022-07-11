<?php

namespace App\Controller;


use App\Repository\AssureRepository;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MembreFamilleRepository;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;

class DefaultController 
{

    public function __invoke(PatientRepository $data)
    {
        // TODO: Implement __invoke() method.

        return $data->getListe(2);
    }

    private $repository;

    public function __construct(AssureRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/ced/phone_auth", name="phone_auth", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function api(Request $request,AssureRepository $repository,NormalizableInterface $normalizable): Response
    {
       $data = $repository->findAll();

        $normaliser = $normalizable->normalize($data);

        dd($normaliser);
       $json = json_encode($data);

       dd($json,$data);
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
