<?php

namespace App\Controller;

use App\Entity\Action;
use App\Entity\Client;
use App\Form\ActionType;
use App\Repository\ActionRepository;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ActionController extends AbstractController
{
    #[Route('/action', name: 'app_action')]
    public function index(ActionRepository $actionRepository): Response
    {
        if ($actionRepository->findAll()){
            $action = $actionRepository->findAll();
            return $this->render('action/index.html.twig', [
                'controller_name' => 'ActionController',
                'actions' => $action,
            ]);
        }
        
        
        return $this->redirectToRoute('create_action');
    }

    #[Route('/create_action', name: 'create_action')]
    public function upload(Request $request, EntityManagerInterface $entityManager, ClientRepository $clientRepository)
    {
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
        ]);
    }
}
