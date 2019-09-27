<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Service\Pagination;
use App\Form\AdminBookingType;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookingController extends AbstractController
{
    /**
     * @Route("/admin/bookings/{page<\d+>?1}", name="admin_bookings")
     */
    public function index(BookingRepository $repo, $page, Pagination $pagination)
    {

        $pagination->setEntityClass(Booking::class)
                   ->setPage($page);

        return $this->render('admin/booking/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Permet d'éditer une réservation
     *
     * @Route("/admin/bookings/{id}/edit", name="admin_booking_edit")
     * 
     * @return Response
     */
    public function edit(Booking $booking, Request $request, ObjectManager $manager){
        $form = $this->createForm(AdminBookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $booking->setAmount(0);
            $manager->flush();

            $this->addFlash(
                'success',
                "La réservation n°{$booking->getId()} à bien été modifiée"
            );

            return $this->redirectToRoute('admin_bookings');
        }

        return $this->render('admin/booking/edit.html.twig', [
            "form" => $form->createView(),
            "booking" => $booking
        ]);
    }

    /**
     * Permet de supprimer une réservation
     *
     * @Route("/admin/bookings/{id}/delete", name="admin_booking_delete")
     * 
     * @param ObjectManager $manager
     * @param Booking $booking
     * @return Response
     */
    public function delete(ObjectManager $manager, Booking $booking){
        $manager->remove($booking);
        $manager->flush();

        $this->addFlash(
            "success",
            "La réservation a bien été suprimée"
        );

        return $this->redirectToRoute("admin_bookings");
    }
}
