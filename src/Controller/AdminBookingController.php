<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\AdminBookingType;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookingController extends AbstractController
{
    /**
     * @Route("/admin/booking", name="admin_booking")
     */
    public function index(BookingRepository $repo)
    {

        return $this->render('admin/booking/index.html.twig', [
            'bookings' => $repo->findAll(),
        ]);
    }
    /**
     * @Route("/admin/bookings/{id}/edit", name="admin_booking_edit")
     */
    public function edit(Booking $booking,Request $request,ObjectManager $manager)
    {

          $form=$this->createForm(AdminBookingType::class,$booking);

          $form->handleRequest($request);

          if($form->isSubmitted() && $form->isValid())
          {
              $booking->setAmount($booking->getAd()->getPrice()* $booking->getDuration());
             $manager->flush();

             $this->addFlash('success',
               
             "La réservation n° ". $booking->getId()." a été bien modifier avec succés"
         );

         return $this->redirectToRoute('admin_booking');
          }

        return $this->render('admin/booking/edit.html.twig',[

            'form'=>$form->createView(),
            'booking'=>$booking
        ]);
    }

    /**
     * @Route("/admin/bookings/{id}/delete", name="admin_booking_delete")
     */
    public function delete(Booking $booking,ObjectManager $manager)
    {

          $manager->remove($booking);

          $this->addFlash('success',
               
          "La réservation n° ". $booking->getId()." a été bien supprimer avec succés"
      );

      return $this->redirectToRoute('admin_booking');
    }
}
