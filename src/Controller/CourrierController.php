<?php

namespace App\Controller;

use App\Entity\Courrier;
use App\Form\CourrierType;
use App\Repository\ClientRepository;
use App\Repository\CourrierRepository;
use App\Repository\NotificationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class CourrierController extends AbstractController
{
    #[Route('/assistante/courrier', name: 'app_courrier')]
    public function index(NotificationRepository $notificationRepository, CourrierRepository $courrierRepository, UserRepository $userRepository): Response
    {


        if ($courrierRepository->findAll()){
            $koko = $this->getUser();
       
            $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
            $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
            $notifications = $user->getNotifications();
            $courrier = $courrierRepository->findAll();
            return $this->render('courrier/list_courrier.html.twig', [
                'controller_name' => 'CourrierController',
                'courriers' => $courrier,
                'notifications' => $notifications,
                'notifCounts' => $notifCounts,
            ]);
        }
        
    }

    #[Route('/admin/courrier', name: 'app_courrier_admin')]
    public function listeAdmin(NotificationRepository $notificationRepository, UserRepository $userRepository, CourrierRepository $courrierRepository): Response
    {
        $koko = $this->getUser();       
        $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
        $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
        $notifications = $user->getNotifications();


        if ($courrierRepository->findBy(['status' => '2'])){



            $courrier = $courrierRepository->findBy(['status' => '2']);
            return $this->render('courrier/list_courrier.html.twig', [
                'controller_name' => 'CourrierController',
                'courriers' => $courrier,
                'notifications' => $notifications,
                'notifCounts' => $notifCounts,
            ]);
        }
        
    }

    #[Route('/compta/courrier', name: 'app_courrier_compta')]
    public function listeCompta(NotificationRepository $notificationRepository, UserRepository $userRepository, CourrierRepository $courrierRepository): Response
    {
        $koko = $this->getUser();       
        $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
        $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
        $notifications = $user->getNotifications();


        if ($courrierRepository->findBy(['status' => '3'])){

            $courrier = $courrierRepository->findBy(['status' => '3']);
            return $this->render('courrier/list_courrier.html.twig', [
                'controller_name' => 'CourrierController',
                'courriers' => $courrier,
                'notifications' => $notifications,
                'notifCounts' => $notifCounts,
            ]);
        }
        
    }

    #[Route('/assistante/create_courrier', name: 'create_courrier')]
    public function add(NotificationRepository $notificationRepository, UserRepository $userRepository, Request $request, EntityManagerInterface $entityManagerInterface, ClientRepository $clientRepository ): Response
    {
        $koko = $this->getUser();       
        $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
        $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
        $notifications = $user->getNotifications();


            $courrier = new Courrier;

            $form = $this->createForm(CourrierType::class, $courrier);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                
                $file = $courrier->getCourrierFile();

                $name = $courrier->getName() . ".pdf";
                
                $courrier->setFilePath($name);
                $file->move(
                    $this->getParameter('courrier_directory'),
                    $name
                );

                $courrier->setName($name);
                $courrier->setUpdatedAt(new \DateTime());
                $nom = $form->get('clientNom')->getData();
                $prenom = $form->get('clientPrenom')->getData();

                $client = $clientRepository->findByFullName($nom, $prenom);
                $courrier->setClient($client);
                $courrier->setStatus($form->get('status')->getData());
                dump($courrier);
                $entityManagerInterface->persist($courrier);
                $entityManagerInterface->flush();
                return $this->redirectToRoute('app_courrier');
            }

            return $this->render('courrier/create_courrier.html.twig', [
                'form' => $form->createView(),
                'notifications' => $notifications,
                'notifCounts' => $notifCounts,
            ]);
    }
    #[Route('/koko/{filename}', name: 'download_courrier', methods:["GET"])]
    public function downloadPdfAction($filename)
    {

        $domain = $_SERVER['HTTP_HOST'];
        $filePath = "https://" . $domain. "/public/courriers/" . $filename;
        $koko = $this->getParameter('kernel.project_dir').'/public/courriers/'. $filename;
        dump(file_exists($koko));
        dump(file_exists('C:\Users\ASUS\git_demo\GESTION-DE-PATRIMOINE\Recouvrement\recouvrement\public\courriers\CourrierLoic1.pdf'));
        dump($domain);
        if (!file_exists($koko)) {
            dump("dzdzdzd");
            $response = new BinaryFileResponse('koko');
            return $response;
        }
        if(file_exists($koko)){
            
            $response = new BinaryFileResponse($koko);
            $response->headers->set('Content-Type', 'application/pdf');
            $response->setContentDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                $filename
            );
            return $response;
        }
        

        
    }

}
