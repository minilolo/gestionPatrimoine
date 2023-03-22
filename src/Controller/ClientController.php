<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use App\Repository\NotificationRepository;
use App\Repository\UserRepository;
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
    #[Route('/admin/client', name: 'app_client')]
    public function index(NotificationRepository $notificationRepository, UserRepository $userRepository, ClientRepository $clientRepository): Response
    {
        $koko = $this->getUser();       
        $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
        $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
        $notifications = $user->getNotifications();

        $clientList = $clientRepository->findAll();

        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
            'clients' => $clientList,
            'notifications' => $notifications,
                'notifCounts' => $notifCounts,
        ]);
    }

    #[Route('/admin/create_client', name: 'create_client', methods:["GET", "POST"])]
    public function add(NotificationRepository $notificationRepository, UserRepository $userRepository,Request $request, EntityManagerInterface $em): Response
    {
        $koko = $this->getUser();       
        $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
        $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
        $notifications = $user->getNotifications();

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
            $Client->setTotal($type->getTotal());
            $Client->setAdresse($type->getAdresse());
            $Client->setOrigin($type->getOrigin());


            $em->persist($Client);
            $em->flush();
            return $this->redirectToRoute('app_client');
            
        }
        return $this->render('client/create_client.html.twig', [
            'form' => $form,
            'notifications' => $notifications,
                'notifCounts' => $notifCounts,
        ]);

    }

    
}
