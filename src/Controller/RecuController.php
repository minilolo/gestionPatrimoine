<?php

namespace App\Controller;

use App\Entity\Recu;
use App\Form\RecuType;
use App\Repository\ClientRepository;
use App\Repository\RecuRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RecuController extends AbstractController
{
    #[Route('/recu', name: 'app_recu')]
    public function index(RecuRepository $recuRepository): Response
    {
        $recuList = $recuRepository->findAll();
        return $this->render('recu/index.html.twig', [
            'recus' => $recuList,
            'controller_name' => 'RecuController',
        ]);
    }

    #[Route('/create_recu', name: 'create_recu', methods:["GET", "POST"])]
    public function add(Request $request, ClientRepository $clientRepository, EntityManagerInterface $em): Response
    {
        $recu = new Recu();
        $form = $this->createForm(
            RecuType::class,
            $recu
        );

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            
            $type = $form->getData();
            $date = new DateTime();
            $recu->setMatricule($type->getMatricule());
            $recu->setCompte("LoloNULL");
            $recu->setObjet("LoloNULL");
            $recu->setMoyen($type->getMoyen());
            $recu->setMontantAriary($type->getMontantAriary());

            //afaka manandrana conversion automatic enao ra misy fotoana : LoicPrime
            $recu->setMontantLettre($type->getMontantLettre());
            $recu->setDate($date);
            $recu->setStatus(False);
            $recu->setDateCreate($type->getDateCreate());
            $nom = $form->get('clientNom')->getData();
            $prenom = $form->get('clientPrenom')->getData();

            
            $client = $clientRepository->findByFullName($nom, $prenom);
            $recu->setClient($client);
            $montantClient = intval($client->getMontant());
            $client->setMontant($montantClient - intval($type->getMontantAriary()));

            $em->persist($recu);
            $em->flush();
            return $this->redirectToRoute('app_recu');
        }
        return $this->render('recu/create_recu.html.twig', [
            'form' => $form
        ]);
    }
}
