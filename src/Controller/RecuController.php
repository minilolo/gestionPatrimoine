<?php

namespace App\Controller;

use App\Entity\Recu;
use App\Form\RecuType;
use App\Repository\ClientRepository;
use App\Repository\NotificationRepository;
use App\Repository\RecuRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RecuController extends AbstractController
{
    #[Route('/admin/recu', name: 'app_recu')]
    public function index(NotificationRepository $notificationRepository, UserRepository $userRepository,RecuRepository $recuRepository): Response
    {

        $koko = $this->getUser();       
        $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
        $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
        $notifications = $user->getNotifications();

        
 
        $recuList = $recuRepository->findAll();
        return $this->render('recu/index.html.twig', [
            'recus' => $recuList,
            
            'notifications' => $notifications,
                'notifCounts' => $notifCounts,
        ]);
    }

    #[Route('/admin/create_recu', name: 'create_recu', methods:["GET", "POST"])]
    public function add(NotificationRepository $notificationRepository, UserRepository $userRepository,Request $request, ClientRepository $clientRepository, EntityManagerInterface $em): Response
    {

        $koko = $this->getUser();       
        $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
        $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
        $notifications = $user->getNotifications();

        
 
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
            $currentMontant = $montantClient - intval($type->getMontantAriary());
            $client->setMontant($currentMontant);
            
            
            if($currentMontant <= 0){
                $client->setStatus(true);
            }
            $em->persist($recu);
            $em->flush();
            return $this->redirectToRoute('app_recu');
        }
        return $this->render('recu/create_recu.html.twig', [
            'form' => $form,
            'notifications' => $notifications,
                'notifCounts' => $notifCounts,
        ]);
    }
}
