<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        
         for($i=0;$i<30;$i++)
         {
             $ad=new Ad;

             $title=$faker->sentence();
             $coverImage=$faker->imageUrl(1000,350);
             $introduction=$faker->paragraph(2);
             $content='<p>'.join('<p></p>',$faker->paragraphs(5)).'</p>';

             $ad->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(mt_rand(40,200))
                ->setRooms(mt_rand(1,5));
               
                 for ($j=0; $j <mt_rand(2,5) ; $j++) 
                 { 
                     $image=new Image;
                     $image->setAd($ad)
                           ->setCaption($faker->sentence())
                           ->setUrl($faker->imageUrl());

                    $manager->persist($image);       
                 }
                $manager->persist($ad);
         }

        $manager->flush();
    }
}
