<?php

namespace App\Controller;

use App\Entity\PdfEntity;
use App\Form\PdfType;
use App\Repository\ClientRepository;
use App\Repository\NotificationRepository;
use App\Repository\PdfEntityRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class PdfController extends AbstractController
{
    #[Route('/admin/pdf', name: 'app_pdf')]
    public function index(NotificationRepository $notificationRepository, UserRepository $userRepository,PdfEntityRepository $pdfEntityRepository): Response
    {

        $koko = $this->getUser();       
        $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
        $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
        $notifications = $user->getNotifications();

        
 
        if($pdfEntityRepository->findAll())
        {
            $pdf = $pdfEntityRepository->findAll();
            return $this->render('pdf/index.html.twig', [
                'pdfs' => $pdf,
                
                'notifications' => $notifications,
                'notifCounts' => $notifCounts,
            ]);
        }

        return $this->redirectToRoute('create_pdf');
    }

    #[Route('/admin/create_pdf', name: 'create_pdf')]
    public function upload(NotificationRepository $notificationRepository, UserRepository $userRepository,Request $request, EntityManagerInterface $entityManager, ClientRepository $clientRepository)
    {

        $koko = $this->getUser();       
        $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
        $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
        $notifications = $user->getNotifications();

        
 
        $pdf = new PdfEntity;

        $form = $this->createForm(PdfType::class, $pdf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $pdf->getPdfFile();

            $title = $pdf->getTitle() . ".pdf";
            
            $pdf->setFilePath($title);
            $file->move(
                $this->getParameter('pdf_directory'),
                $title
            );

            $pdf->setTitle($title);
            $pdf->setUpdatedAt(new \DateTime());
            $nom = $form->get('clientNom')->getData();
            $prenom = $form->get('clientPrenom')->getData();

            
            $client = $clientRepository->findByFullName($nom, $prenom);
            $pdf->setClient($client);
            $entityManager->persist($pdf);
            $entityManager->flush();
            

            return $this->redirectToRoute('app_pdf');
        }

        return $this->render('pdf/pdf_upload.html.twig', [
            'form' => $form->createView(),
            'notifications' => $notifications,
                'notifCounts' => $notifCounts,
        ]);
}

#[Route('/pdfdownload/{filename}', name: 'download_pdf', methods:["GET"])]
    public function downloadPdfAction($filename)
    {

        $domain = $_SERVER['HTTP_HOST'];
        $filePath = "https://" . $domain. "/public/courriers/" . $filename;
        $koko = $this->getParameter('kernel.project_dir').'/public/pdfs/'. $filename;
        dump(file_exists($koko));
        dump($koko);
        dump(file_exists('C:\Users\ASUS\git_demo\GESTION-DE-PATRIMOINE\Recouvrement\recouvrement\public\courriers\CourrierLoic1.pdf'));
        dump($domain);
        if (!file_exists($koko)) {
            dump("ERROR");
            dump("dzdzdzd");
            $response = 'koko';
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