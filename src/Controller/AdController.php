<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AnnonceType;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo)
    {
       

        $ads=$repo->findAll();
        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }

    /**
     * @Route("ads/new",name="ads_create")
     */
    public function create(Request $request,ObjectManager $manager)
    {
        $ad=new Ad;

            
        $form=$this->createForm(AnnonceType::class,$ad);

        $form->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid())
        {
               
             foreach ($ad->getImages() as  $image) {
                 
                $image->setAd($ad);

                $manager->persist($image);
             }

             $ad->setAuthor($this->getUser());
             $manager->persist($ad);
             $manager->flush();


             $this->addFlash(
                 'success',
                 "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrer"
             );

             return $this->redirectToRoute("ads_show",[

                  'slug'=>$ad->getSlug()
             ]);
        }

       return $this->render('ad/new.html.twig',[
           'form'=>$form->createView()
       ]);
    }

    /**
     * @Route("ads/{slug}/edit",name="ads_edit")
     *
     * @return void
     */
    public function edit(Request $request,Ad $ad,ObjectManager $manager)
    {
        $form=$this->createForm(AnnonceType::class,$ad);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
               
             foreach ($ad->getImages() as  $image) {
                 
                $image->setAd($ad);

                $manager->persist($image);
             }
             $manager->persist($ad);
             $manager->flush();


             $this->addFlash(
                 'success',
                 "L'annonce <strong>{$ad->getTitle()}</strong> a bien été mis a jour avec succes"
             );

             return $this->redirectToRoute("ads_show",[

                  'slug'=>$ad->getSlug()
             ]);
        }


        return $this->render('ad/edit.html.twig',[

            'form'=>$form->createView(),
            'ad'=>$ad
        ]);
    }

    /**
     * @Route("ads/{slug}",name="ads_show")
     */
    public function show(Ad $ad)
    {

         return $this->render('ad/show.html.twig',[

            'ad'=>$ad
         ]);
    }

    
}
