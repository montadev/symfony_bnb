<?php

namespace App\Controller;

use App\Service\StatsService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function index(ObjectManager $manager,StatsService $statsService)
    {
        $users=$statsService->getUserCount();
        
        $ads=$statsService->getAdsCount();
        
        $bookings=$statsService->getBookingsCount();  
        
        $comments=$statsService->getCommentsCount();                

                        
        $bestAds=$statsService->getBestAds();


        $worseAds=$statsService->getWorseService();
        
         
        return $this->render('admin/dashboard/index.html.twig', [
            
            'users'=>$users,
            'ads'=>$ads,
            'bookings'=>$bookings,
            'comments'=>$comments,
            'bestAds'=>$bestAds,
            'worseAds'=>$worseAds
        ]);
    }
}
