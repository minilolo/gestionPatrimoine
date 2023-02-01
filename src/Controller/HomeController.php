<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(ClientRepository $clientRepository): Response
    {

        $client = $clientRepository->countAll();
        $montant = $clientRepository->countCredit();
        $clientActive = $clientRepository->countAllActive();
        $clientFini = $client - $clientActive;
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'client' => $client,
            'montant' => $montant,
            'clientActive' => $clientActive,
            'clientFini' => $clientFini,
        ]);
    }
    
}
