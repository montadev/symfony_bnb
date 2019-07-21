<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
     
     private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder=$encoder;
    }
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $adminRole=new Role;
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);
        

        
        $adminUser=new User;
        $password=$this->encoder->encodePassword($adminUser,'password');

        $adminUser->setFirstName('Hermi');
        $adminUser->setLastName('Montassar');
        $adminUser->setEmail('montasar.hermi@gmail.com');
        $adminUser->setIntroduction($faker->sentence());
        $adminUser->setDescription('<p>'.join('</p><p>',$faker->paragraphs(3)).'</p>');
        $adminUser->setPassword($password);

        $adminUser->setPicture('https://randomuser.me/api/portraits/men/11.jpg');
        $adminUser->addUserRole($adminRole);

        $manager->persist($adminUser);
        //nous gerons les utilisateurs
        $users=[];
        $genres=['male','female'];
         for ($i=0; $i <10 ; $i++) { 
             
            $user=new User();

            $genre=$faker->randomElement($genres);

            $picture='https://randomuser.me/api/portraits/';

            $pictureId=$faker->numberBetween(1,90).'.jpg';

            if($genre=='male')
            {
                $picture=$picture.'men/'.$pictureId;
            }else
            {
                $picture=$picture.'women/'.$pictureId;
            }

            $password=$this->encoder->encodePassword($user,'password');

            $user->setFirstName($faker->firstname($genre));
            $user->setLastName($faker->lastname);
            $user->setEmail($faker->email);
            $user->setIntroduction($faker->sentence());
            $user->setDescription('<p>'.join('</p><p>',$faker->paragraphs(3)).'</p>');
            $user->setPassword($password);

            $user->setPicture($picture);

            $manager->persist($user);

            $users[]=$user;
         }


        //nous gerons les articles
         for($i=0;$i<30;$i++)
         {
             $ad=new Ad;

             $title=$faker->sentence();
             $coverImage=$faker->imageUrl(1000,350);
             $introduction=$faker->paragraph(2);
             $content='<p>'.join('<p></p>',$faker->paragraphs(5)).'</p>';

             $user=$users[mt_rand(0,count($users)-1)];
             $ad->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(mt_rand(40,200))
                ->setRooms(mt_rand(1,5))
                ->setAuthor($user);
               
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
