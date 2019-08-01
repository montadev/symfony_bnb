<?php 

namespace App\Service;

use Doctrine\Common\Persistence\ObjectManager;

class StatsService{

    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager=$manager;
    }

    public function getUserCount(){

        $users=$this->manager->createQuery('SELECT count(u) FROM App\Entity\User u')
                        ->getSingleScalarResult();

         return $users;               
    }

    public function getAdsCount(){

       return  $this->manager->createQuery('SELECT count(u) FROM App\Entity\Ad u')
        ->getSingleScalarResult();
    }

    public function getBookingsCount(){

       return  $this->manager->createQuery('SELECT count(u) FROM App\Entity\Booking u')
                        ->getSingleScalarResult();
    }

    public function getCommentsCount(){

        return $this->manager->createQuery('SELECT count(u) FROM App\Entity\Comment u')
        ->getSingleScalarResult(); 
    }

    public function getBestAds(){

       return $this->manager->createQuery('SELECT AVG(c.rating) as note ,a.title,u.firstName,
        u.lastName,u.picture
        FROM App\Entity\Comment c
        Join c.ad as a
        Join c.author as u

        GROUP BY a
        Order BY note DESC
       
       ')->setMaxResults(5)
        ->getResult();
    }

    public function getWorseService(){

        return $this->manager->createQuery('SELECT AVG(c.rating) as note ,a.title,u.firstName,
        u.lastName,u.picture
        FROM App\Entity\Comment c
        Join c.ad as a
        Join c.author as u

        GROUP BY a
        Order BY note ASC
       
       ')->setMaxResults(5)
        ->getResult();
    }
}