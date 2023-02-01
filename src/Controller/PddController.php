<?php

namespace App\Controller;

use App\Entity\PointDeDossier;
use App\Form\PddType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PddController extends AbstractController
{
    #[Route('/pdd', name: 'app_pdd')]
    public function index(): Response
    {
        return $this->render('pdd/index.html.twig', [
            'controller_name' => 'PddController',
        ]);
    }

    #[Route('/create_pdd', name: 'create_pdd')]
    public function upload(Request $request, EntityManagerInterface $entityManager, ClientRepository $clientRepository)
    {
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
            

            return $this->redirectToRoute('app_pdf');
        }

        return $this->render('pdd/pdd_upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
