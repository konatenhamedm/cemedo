<?php

namespace App\Controller;


use App\Repository\PatientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MembreFamilleRepository;

class DefaultController 
{

    public function __invoke(PatientRepository $data)
    {
        // TODO: Implement __invoke() method.

        return $data->getListe(2);
    }

    public function api(){

    }
}
