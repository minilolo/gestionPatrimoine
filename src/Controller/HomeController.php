<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use App\Repository\CourrierRepository;
use App\Repository\EntrerRepository;
use App\Repository\NotificationRepository;
use App\Repository\SortieRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    #[Route('/accueil', name: 'app_home')]
    public function index(NotificationRepository $notificationRepository, UserRepository $userRepository, ClientRepository $clientRepository, EntrerRepository $entrerRepository, CourrierRepository $courrierRepository, SortieRepository $sortieRepository): Response
    {
            if ($this->isGranted('ROLE_USER'))
            {
                $koko = $this->getUser();
       
                $user = $userRepository->findOneBy(['email' => $koko->getUserIdentifier()]);
                $notifCounts = $notificationRepository->GetNotificationCountByUser($user);
                $notifications = $user->getNotifications();
        
            }
            if(!($this->isGranted('ROLE_USER'))){
                $notifCounts = 0;
                $notifications = []; 
            }
        

        $today = new DateTime();
        $year = (new DateTime)->format('Y');
        $month = (new DateTime)->format('m');
        $year2 = "2000";
        $startOfYear = new DateTime("$year-01-01 00:00:00");
        $startOfMonth= new DateTime("$year-$month-01 00:00:00");
        $thisYearExpense = $sortieRepository->getExpensesByYear($startOfYear, $today);
        $thisYearProduct = $entrerRepository->getExpensesByYear($startOfYear, $today);
        $thisMonthExpense = $sortieRepository->getExpensesByYear($startOfMonth, $today);
        $thisMonthProduct = $entrerRepository->getExpensesByYear($startOfMonth, $today);
        $client = $clientRepository->countAll();
        $montant = $clientRepository->countCredit();
        $clientActive = $clientRepository->countAllActive();
        $clientFini = $client - $clientActive;
        $courrier = $courrierRepository->CountAll();


        $thisYearExpenseAll = $sortieRepository->getExpensesAll($startOfYear, $today);
        $everyMonthAverageExpense = $sortieRepository->getExpenseAverageThisMonth($startOfYear, $today);
        $everyMonthAverageRevenu = $entrerRepository->getRevenuAverageThisMonth($startOfYear, $today);
        dump($thisYearExpenseAll);
        if (!$thisYearExpense){
            $thisYearExpense = "0";
        }
        if (!$thisYearProduct){
            $thisYearProduct = "0";
        }
        if (!$thisMonthExpense){
            $thisMonthExpense = "0";
        }
        if (!$thisMonthProduct){
            $thisMonthProduct = "0";
        }
        dump($everyMonthAverageExpense);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'client' => $client,
            'montant' => $montant,
            'clientActive' => $clientActive,
            'clientFini' => $clientFini,
            'courrier' => $courrier,
            'thisYearExpense' => $thisYearExpense,
            'thisYearProduct' => $thisYearProduct,
            'thisMonthExpense' => $thisMonthExpense,
            'thisMonthProduct' => $thisMonthProduct,
            'thisYearExpenseAlls' => $thisYearExpenseAll,
            'everyMonthAverageExpenses' => $everyMonthAverageExpense,
            'everyMonthAverageRevenus' => $everyMonthAverageRevenu,
            'notifications' => $notifications,
            'notifCounts' => $notifCounts,
        ]);
    }
    
}
