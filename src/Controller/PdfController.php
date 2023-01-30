<?php

namespace App\Controller;

use App\Entity\PdfEntity;
use App\Form\PdfType;
use App\Repository\ClientRepository;
use App\Repository\PdfEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PdfController extends AbstractController
{
    #[Route('/pdf', name: 'app_pdf')]
    public function index(PdfEntityRepository $pdfEntityRepository): Response
    {
        $pdf = $pdfEntityRepository->findAll();

        return $this->render('pdf/index.html.twig', [
            'pdfs' => $pdf,
            'controller_name' => 'PdfController',
        ]);
    }

    #[Route('/create_pdf', name: 'create_pdf')]
    public function upload(Request $request, EntityManagerInterface $entityManager, ClientRepository $clientRepository)
    {
        $pdf = new PdfEntity;

        $form = $this->createForm(PdfType::class, $pdf);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $pdf->getPdfFile();

            $title = $pdf->getTitle() . ".pdf";
            $client = $pdf->getClient();
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
        ]);
}
}