<?php

namespace App\Controller;

use App\Entity\Sortie;

use App\Form\SortieType;
use App\Repository\NotificationRepository;
use App\Repository\SortieRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortieController extends AbstractController
{
    #[Route('/compta/sortie', name: 'app_sortie')]
    public function index(NotificationRepository $notificationRepository, UserRepository $userRepository,SortieRepository $sortieRepository): Response
    {

        $koko = $this->getUser();       
        $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
        $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
        $notifications = $user->getNotifications();

        
 
        
        
        $sortie = $sortieRepository->findAll();
        $sortieCount = count($sortie);
        return $this->render('sortie/list_sortie.html.twig', [
            
            'sorties' => $sortie,
            'number' => $sortieCount,
            'notifications' => $notifications,
                'notifCounts' => $notifCounts,
        ]);
    }

    #[Route('/compta/create_sortie', name: 'create_sortie')]
    public function add(NotificationRepository $notificationRepository, UserRepository $userRepository,Request $request, EntityManagerInterface $entityManagerInterface): Response
    {

        $koko = $this->getUser();       
        $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
        $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
        $notifications = $user->getNotifications();

        
 
            $sortie = new Sortie;

            $form = $this->createForm(SortieType::class, $sortie);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                
                $data = $form->getData();
                
                $sortie->setDate($data->getDate());
                $sortie->setDescription($data->getDescription());
                $sortie->setAmount($data->getAmount());
                $sortie->setMethod($data->getMethod());
                $sortie->setCategorie($data->getCategorie());
                

                $entityManagerInterface->persist($sortie);
                $entityManagerInterface->flush();
                return $this->redirectToRoute('app_sortie');
                
            }

            return $this->render('sortie/create_sortie.html.twig', [
                'form' => $form->createView(),
                'notifications' => $notifications,
                'notifCounts' => $notifCounts,
            ]);
    }
}
