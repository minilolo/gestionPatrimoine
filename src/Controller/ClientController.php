<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function index(ClientRepository $clientRepository): Response
    {
        
        $clientList = $clientRepository->findAll();

        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
            'clients' => $clientList
        ]);
    }

    #[Route('/create_client', name: 'create_client', methods:["GET", "POST"])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $Client = new Client();
        $form = $this->createForm(
            ClientType::class,
            $Client
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $data = $request->request->all();
            $type = $form->getData();
            $date = new DateTime();
            $Client->setNom($type->getNom());
            $Client->setPrenom($type->getPrenom());
            $Client->setBirthDate($type->getBirthDate());
            $Client->setDateInsertion($date);
            $Client->setStatus(True);
            $Client->setMontant($type->getMontant());
            
            $em->persist($Client);
            $em->flush();
            return $this->redirectToRoute('app_client');
            
        }
        return $this->render('client/create_client.html.twig', [
            'form' => $form
        ]);

    }

    
}
