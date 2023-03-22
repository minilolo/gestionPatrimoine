<?php

namespace App\Controller;

use App\Entity\PointDeDossier;
use App\Form\PddType;
use App\Repository\ClientRepository;
use App\Repository\NotificationRepository;
use App\Repository\PointDeDossierRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class PddController extends AbstractController
{
    #[Route('/admin/pdd', name: 'app_pdd')]
    public function index(NotificationRepository $notificationRepository, UserRepository $userRepository, PointDeDossierRepository $pointDeDossierRepository): Response
    {

        $koko = $this->getUser();       
        $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
        $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
        $notifications = $user->getNotifications();

        $pdd = $pointDeDossierRepository->findAll();
        return $this->render('pdd/index.html.twig', [
            'controller_name' => 'PddController',
            'pdds' => $pdd,
            'notifications' => $notifications,
                'notifCounts' => $notifCounts,
        ]);
    }

    #[Route('/admin/create_pdd', name: 'create_pdd')]
    public function upload(NotificationRepository $notificationRepository, UserRepository $userRepository,Request $request, EntityManagerInterface $entityManager, ClientRepository $clientRepository)
    {

        $koko = $this->getUser();       
        $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
        $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
        $notifications = $user->getNotifications();


        $pdd = new PointDeDossier;

        $form = $this->createForm(PddType::class, $pdd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $pdd->getPddFile();

            $title = $pdd->getTitle() . ".pdf";
            
            $pdd->setFilePath($title);
            $file->move(
                $this->getParameter('pdf_directory'),
                $title
            );

            $pdd->setTitle($title);
            $pdd->setUpdatedAt(new \DateTime());
            $nom = $form->get('clientNom')->getData();
            $prenom = $form->get('clientPrenom')->getData();

            
            $client = $clientRepository->findByFullName($nom, $prenom);
            $pdd->setClient($client);
            $entityManager->persist($pdd);
            $entityManager->flush();
            

            return $this->redirectToRoute('app_pdd');
        }

        return $this->render('pdd/pdd_upload.html.twig', [
            'form' => $form->createView(),
            'notifications' => $notifications,
                'notifCounts' => $notifCounts,
        ]);
    }
    #[Route('/pdddownload/{filename}', name: 'download_pdd', methods:["GET"])]
    public function downloadPdfAction($filename)
    {

        $domain = $_SERVER['HTTP_HOST'];
        $filePath = "https://" . $domain. "/public/courriers/" . $filename;
        $koko = $this->getParameter('kernel.project_dir').'/public/pdfs/'. $filename;
        dump(file_exists($koko));
        dump(file_exists('C:\Users\ASUS\git_demo\GESTION-DE-PATRIMOINE\Recouvrement\recouvrement\public\courriers\CourrierLoic1.pdf'));
        dump($domain);
        if (!file_exists($koko)) {
            dump("ERRORPDD");
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
