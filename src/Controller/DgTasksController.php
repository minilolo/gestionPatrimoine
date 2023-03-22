<?php

namespace App\Controller;

use App\Entity\DgTasks;
use App\Entity\Notification;
use App\Entity\User;
use App\Form\DgTasksType;
use App\Repository\ClientRepository;
use App\Repository\DgTasksRepository;
use App\Repository\NotificationRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DgTasksController extends AbstractController
{
    #[Route('/dg/tasks', name: 'app_dg_tasks')]
    public function index(NotificationRepository $notificationRepository,DgTasksRepository $dgTasksRepository, UserRepository $userRepository): Response
    {
        $koko = $this->getUser();       
        $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
        $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
        $notifications = $user->getNotifications();


        $tasks = $dgTasksRepository->findAll();
        
       
        
  
        return $this->render('dg_tasks/list_tasks.html.twig', [
            
            'tasks' => $tasks,
           
                'notifications' => $notifications,
                'notifCounts' => $notifCounts,
        ]);
    }

    #[Route('/dg/create_tasks', name: 'create_tasks', methods:["GET", "POST"])]
    public function add(Request $request, NotificationRepository $notificationRepository, EntityManagerInterface $entityManagerInterface, UserRepository $userRepository): Response
    {
        $koko = $this->getUser();       
        $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
        $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
        $notifications = $user->getNotifications();



        
        $dgTasks = new DgTasks();
        $notification = new Notification();
        $form = $this->createForm(
            DgTasksType::class,
            $dgTasks
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            
            $data = $form->getData();
            
            $refClass = new \ReflectionClass($data);
            $properties = $refClass->getProperties(\ReflectionProperty::IS_PUBLIC |
             \ReflectionProperty::IS_PROTECTED |
              \ReflectionProperty::IS_PRIVATE);

              $boolProperties = array_filter($properties, function($property) use ($data) {
                if ($property->getType() && $property->getType()->getName() === 'bool') {
                    $property->setAccessible(true);
                    return $property->getValue($data) === true;
                }
            });

            $content = [];
            
            $counter = 0;
            $assistantes = $userRepository->findByRole("ROLE_ASSISTANT");
            $prmps = $userRepository->findByRole("ROLE_PRMP");
            $dajs = $userRepository->findByRole("ROLE_DAJ");
            $dafs = $userRepository->findByRole("ROLE_DAF");
            $snds = $userRepository->findByRole("ROLE_SND");
            $srhas = $userRepository->findByRole("ROLE_SRHA");
            $scofis = $userRepository->findByRole("ROLE_SCOFI");
            $sads = $userRepository->findByRole("ROLE_SAD");
            if($data->isAd()){
                
                if(count($assistantes))
                {
                    for ($i = 0; $i < count($assistantes); $i++){
                        $notification->setType("popup");
                        $notification->addUser($assistantes[$i]);
                        
                        foreach ($boolProperties as $bool){
                            array_push($content, $bool->getName());
                        }
                        $notification->setContent(implode(', ', $content));

                        $notification->setStatus("unread");
                        $notification->setDate(new DateTime());
                        dump($notification);
                        $entityManagerInterface->persist($notification);
                        $entityManagerInterface->flush();
                        $content = [];
                    }
                    
                }

                
            }
            if($data->isPrmp()){
                if(count($prmps))
                {
                    for ($i = 0; $i < count($prmps); $i++){
                        $notification->setType("popup");
                        $notification->addUser($prmps[$i]);
                        
                        foreach ($boolProperties as $bool){
                            
                            array_push($content, $bool->getName());
                        }
                        $notification->setContent(implode(', ', $content));
                        $notification->setStatus("unread");
                        $notification->setDate(new DateTime());
                        dump($notification);
                        $entityManagerInterface->persist($notification);
                        $entityManagerInterface->flush();
                        $content = [];
                    }
                    
                }
            }
            if($data->isDaj()){
                if(count($dajs))
                {
                    for ($i = 0; $i < count($dajs); $i++){
                        $notification->setType("popup");
                        $notification->addUser($dajs[$i]);
                        foreach ($boolProperties as $bool){
                            array_push($content, $bool->getName());
                        }
                        $notification->setContent(implode(', ', $content));
                        $notification->setStatus("unread");
                        $notification->setDate(new DateTime());
                        dump($notification);
                        $entityManagerInterface->persist($notification);
                        $entityManagerInterface->flush();
                        $content = [];
                    }
                    
                }
            }
            if($data->isDaf()){
                if(count($dafs))
                {
                    for ($i = 0; $i < count($dafs); $i++){
                        $notification->setType("popup");
                        $notification->addUser($dafs[$i]);
                        foreach ($boolProperties as $bool){
                            array_push($content, $bool->getName());
                        }
                        $notification->setContent(implode(', ', $content));
                        $notification->setStatus("unread");
                        $notification->setDate(new DateTime());
                        dump($notification);
                        $entityManagerInterface->persist($notification);
                        $entityManagerInterface->flush();
                        $content = [];
                    }
                    
                }
            }
            if($data->isSnd()){
                if(count($snds))
                {
                    for ($i = 0; $i < count($snds); $i++){
                        $notification->setType("popup");
                        $notification->addUser($snds[$i]);
                        foreach ($boolProperties as $bool){
                            array_push($content, $bool->getName());
                        }
                        $notification->setContent(implode(', ', $content));
                        $notification->setStatus("unread");
                        $notification->setDate(new DateTime());
                        dump($notification);
                        $entityManagerInterface->persist($notification);
                        $entityManagerInterface->flush();
                        $content = [];
                    }
                    
                }
            }
            if($data->isSrha()){
                if(count($srhas))
                {
                    for ($i = 0; $i < count($srhas); $i++){
                        $notification->setType("popup");
                        $notification->addUser($srhas[$i]);
                        foreach ($boolProperties as $bool){
                            array_push($content, $bool->getName());
                        }
                        $notification->setContent(implode(', ', $content));
                        $notification->setStatus("unread");
                        $notification->setDate(new DateTime());
                        dump($notification);
                        $entityManagerInterface->persist($notification);
                        $entityManagerInterface->flush();
                        $content = [];
                    }
                    
                }
            }
            if($data->isScofi()){
                if(count($scofis))
                {
                    for ($i = 0; $i < count($scofis); $i++){
                        $notification->setType("popup");
                        $notification->addUser($scofis[$i]);
                        foreach ($boolProperties as $bool){
                            array_push($content, $bool->getName());
                        }
                        $notification->setContent(implode(', ', $content));
                        $notification->setStatus("unread");
                        $notification->setDate(new DateTime());
                        dump($notification);
                        $entityManagerInterface->persist($notification);
                        $entityManagerInterface->flush();
                        $content = [];
                    }
                    
                }
            }
            if($data->isSad()){
                if(count($sads))
                {
                    for ($i = 0; $i < count($sads); $i++){
                        $notification->setType("popup");
                        $notification->addUser($sads[$i]);
                        foreach ($boolProperties as $bool){
                            array_push($content, $bool->getName());
                        }
                        $notification->setContent(implode(', ', $content));
                        $notification->setStatus("unread");
                        $notification->setDate(new DateTime());
                        dump($notification);
                        $entityManagerInterface->persist($notification);
                        $entityManagerInterface->flush();
                        $content = [];
                    }
                    
                }
            }


            
            $dgTasks->setAd($data->isAd());
            $dgTasks->setPrmp($data->isPrmp());
            $dgTasks->setDaj($data->isDaj());
            $dgTasks->setDaf($data->isDaf());
            $dgTasks->setSnd($data->isSnd());
            $dgTasks->setSrha($data->isSrha());
            $dgTasks->setScofi($data->isScofi());
            $dgTasks->setSad($data->isSad());
            $dgTasks->setSuiteADonner($data->isSuiteADonner());
            $dgTasks->setEnParlerAuTelephone($data->isEnParlerAuTelephone());
            $dgTasks->setVenirEnParler($data->isVenirEnParler());
            $dgTasks->setProspectionDeCandidature($data->isProspectionDeCandidature());
            $dgTasks->setGarderEnInstance($data->isGarderEnInstance());
            $dgTasks->setEnFaireUneNote($data->isEnFaireUneNote());
            $dgTasks->setAffichage($data->isAffichage());
            $dgTasks->setCopieAMeRetourner($data->isCopieAMeRetourner());
            $dgTasks->setSuivi($data->isSuivi());
            $dgTasks->setAttribution($data->isAttribution());
            $dgTasks->setInformation($data->isInformation());
            $dgTasks->setRappeler($data->isRappeler());
            $dgTasks->setRendreCompte($data->isRendreCompte());
            $dgTasks->setProcedureASuivre($data->isProcedureASuivre());
            $dgTasks->setRepresenter($data->isRepresenter());
            $dgTasks->setEtudeEtEnParler($data->isEtudeEtEnParler());
            $dgTasks->setClassement($data->isClassement());
            $dgTasks->setRemettre($data->isRemettre());
            $dgTasks->setClient($data->getClient());
            dump($dgTasks);
            $entityManagerInterface->persist($dgTasks);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('app_dg_tasks');
            
            
        }
        return $this->render('dg_tasks/create_tasks.html.twig', [
            'form' => $form,
            'notifications' => $notifications,
            'notifCounts' => $notifCounts,
        ]);

    }

}
