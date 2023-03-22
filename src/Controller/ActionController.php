<?php

namespace App\Controller;

use App\Entity\Action;
use App\Entity\Client;
use App\Form\ActionType;
use App\Repository\ActionRepository;
use App\Repository\ClientRepository;
use App\Repository\NotificationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\Length;

class ActionController extends AbstractController
{
    #[Route('/admin/action', name: 'app_action')]
    public function index(NotificationRepository $notificationRepository, UserRepository $userRepository, ActionRepository $actionRepository): Response
    {
        $koko = $this->getUser();       
        $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
        $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
        $notifications = $user->getNotifications();


        if ($actionRepository->findAll()){
            $action = $actionRepository->findAll();
            $trier = $actionRepository->actionByClient();
            return $this->render('action/index.html.twig', [
                'controller_name' => 'ActionController',
                'actions' => $action,
                'triers' => $trier,
                'notifications' => $notifications,
                'notifCounts' => $notifCounts,
            ]);
        }
        
        
        return $this->redirectToRoute('create_action');
    }
    #[Route('/admin/trier_action', name: 'trier_action')]
    public function actiontrier(NotificationRepository $notificationRepository, UserRepository $userRepository,ActionRepository $actionRepository, ClientRepository $clientRepository): Response
    {

        $koko = $this->getUser();       
        $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
        $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
        $notifications = $user->getNotifications();

        if ($actionRepository->findAll()){
            
            $trier = $actionRepository->actionByClient();
            $client = array();
            for ($i = 0; $i < count($trier); $i++){
                    array_push($client, $clientRepository->findBy(['id' => $trier[$i]]));
            }

            
            
            $triers = array();
            for($i = 0; $i < count($trier); $i++){

                array_push($triers, $actionRepository->findOneBy(['client' => $client[$i]]));

            }
            
            
            return $this->render('action/date-action.html.twig', [
               
               
                'triers' => $triers,
                'notifications' => $notifications,
                'notifCounts' => $notifCounts,
            ]);
            return $this->render('action/index.html.twig', [
                
                
                'triers' => $trier,
                'notifications' => $notifications,
                'notifCounts' => $notifCounts,
            ]);
        }
        
        
        return $this->redirectToRoute('create_action');
    }

    #[Route('/admin/create_action', name: 'create_action')]
    public function upload(NotificationRepository $notificationRepository, UserRepository $userRepository,Request $request, EntityManagerInterface $entityManager, ClientRepository $clientRepository)
    {

        $koko = $this->getUser();       
        $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
        $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
        $notifications = $user->getNotifications();

        $action = new Action;

        $form = $this->createForm(ActionType::class, $action);
        $form->handleRequest($request);
        dump("kokokokokokook");
        if ($form->isSubmitted() && $form->isValid()) {
            dump("aefrgerhzthzthzrhtzhtrthtrh");
            /** @var UploadedFile $file */
            $file = $action->getActionFile();

            $title = $action->getTitle() . ".pdf";
            $nature = $action->getNature();
            $action->setFilePath($title);
            $file->move(
                $this->getParameter('action_directory'),
                $title
            );

            $action->setTitle($title);
            $action->setNature($nature);
            $action->setDate($form->get('date')->getData());
            $nom = $form->get('clientNom')->getData();
            $prenom = $form->get('clientPrenom')->getData();

            
            $client = $clientRepository->findByFullName($nom, $prenom);
            $action->setClient($client);
            $entityManager->persist($action);
            $entityManager->flush();
            

            return $this->redirectToRoute('app_action');
        }

        return $this->render('action/action_upload.html.twig', [
            'form' => $form->createView(),
            'notifications' => $notifications,
                'notifCounts' => $notifCounts,
        ]);
    }
}
