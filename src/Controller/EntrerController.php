<?php

namespace App\Controller;

use App\Entity\Entrer;
use App\Form\EntrerType;
use App\Repository\ClientRepository;
use App\Repository\EntrerRepository;
use App\Repository\NotificationRepository;
use App\Repository\SortieRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntrerController extends AbstractController
{
    #[Route('/compta/entrer', name: 'app_entrer')]
    public function index(NotificationRepository $notificationRepository, UserRepository $userRepository,EntrerRepository $entrerRepository): Response
    {
        $koko = $this->getUser();       
        $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
        $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
        $notifications = $user->getNotifications();


        $entrer = $entrerRepository->findAll();
        return $this->render('entrer/list_entrer.html.twig', [
            'controller_name' => 'EntrerController',
            'entrers' => $entrer,
            'notifications' => $notifications,
            'notifCounts' => $notifCounts,
        ]);
    }

    #[Route('/compta/create_courrier', name: 'create_entrer')]
    public function add(NotificationRepository $notificationRepository, UserRepository $userRepository,Request $request, EntityManagerInterface $entityManagerInterface, ClientRepository $clientRepository): Response
    {
        $koko = $this->getUser();       
        $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
        $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
        $notifications = $user->getNotifications();


            $entrer = new Entrer;

            $form = $this->createForm(EntrerType::class, $entrer);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                
                $data = $form->getData();
                
                $entrer->setNature($data->getNature());
                $entrer->setQuantity($data->getQuantity());
                $entrer->setMethode($data->getMethode());
                $entrer->setDate($data->getDate());
                $entrer->setUpdatedAt(new DateTime());
                if ($form->get('clientBE')->getdata()){
                    $string = $form->get('clientBE')->getdata();
                    $mot = explode(" ", $string);
                    $nom = $mot[0];
                    $array = array();
                    $prenom = "";
                    
                    for ($i = 1; $i < count($mot); $i++){
                            array_push($array, $mot[$i]);
                    }
                    $prenom = $array[0];
                    for ($i = 1; $i < count($array); $i++){
                        $prenom = $prenom . " " . $array[$i];
                    }
                    
                    
                    if($clientRepository->findByFullName($nom, $prenom)){
                        
                        $client = $clientRepository->findByFullName($nom, $prenom);
                        $entrer->setClient($client);
                    }
                }
                

                $entityManagerInterface->persist($entrer);
                $entityManagerInterface->flush();
                return $this->redirectToRoute('app_entrer');
                
            }

            return $this->render('entrer/create_entrer.html.twig', [
                'form' => $form->createView(),
                'notifications' => $notifications,
            'notifCounts' => $notifCounts,
            ]);
    }

    #[Route('/compta/liste_livre', name: 'liste_livre')]
    public function livre(NotificationRepository $notificationRepository, UserRepository $userRepository,EntrerRepository $entrerRepository, SortieRepository $sortieRepository): Response
    {
        $koko = $this->getUser();       
        $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
        $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
        $notifications = $user->getNotifications();



        $entrer = $entrerRepository->findAll();
        $sortie = $sortieRepository->findAll();
        return $this->render('entrer/list_livre.html.twig', [
            'controller_name' => 'EntrerController',
            'entrers' => $entrer,
            'notifications' => $notifications,
            'notifCounts' => $notifCounts,
        ]);
    }
}
