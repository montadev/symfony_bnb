<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\Comment;
use App\Form\BookingType;
use App\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class BookingController extends AbstractController
{
    /**
     * @Route("/ads/{slug}/booking", name="booking_create")
     * @IsGranted("ROLE_USER")
     */
    public function book(Ad $ad,Request $request,ObjectManager $manager)
    {
        
        $booking=new Booking;
        $form=$this->createForm(BookingType::class,$booking);

       
        $form->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid())
        {
            
            $user=$this->getUser();
            $booking->setBooker($user)
                    ->setAd($ad);

                    if(!$booking->isBookableDates())
                    {
                        $this->addFlash(
                            'warning',
                            "Les dates que vous avez choisi sont déja prises ."
                        );

                    } 
                    else
                    {
                       
                        $manager->persist($booking);

                        $manager->flush();

                        return $this->redirectToRoute('booking_show',['id'=>$booking->getId(),
            
                        'withAlert'=>true
                        ]);
                 
                    }

            
        }
        return $this->render('booking/book.html.twig', [
            'ad' => $ad,
            'form'=>$form->createView()
        ]);
    }
  /**
   * @Route("booking/{id}",name="booking_show")
   * @Security("is_granted('ROLE_USER') and user===booking.getBooker()")
   */
    public function show(Booking $booking,Request $request,ObjectManager $manager)
    {
        $comment=new Comment();
        $form=$this->createForm(CommentType::class,$comment);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {

             
         $comment->setAd($booking->getAd());
         $comment->setAuthor($this->getUser());
         
         $manager->persist($comment);

         $manager->flush();

         $this->addFlash(

             'success',
             "Votre commentaire a bien été pris en compte"
         );

        }
     return $this->render('booking/show.html.twig',[

          'booking'=>$booking,
          'form'=>$form->createView()
     ]); 
    }
}
