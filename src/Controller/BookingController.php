<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Festival;
use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;

#[Route('/booking')]
final class BookingController extends AbstractController
{
    #[Route('/{id}', name: 'app_booking', methods: ['POST'])]
    public function book(Request $request, Festival $festival, EntityManagerInterface $entityManager): Response
    {
        // Check if this is the initial "Book" button click
        if ($request->getPayload()->has('_token') && !$request->getPayload()->has('booking')) {
            // This is the initial booking request from festival list
            $submitedToken = $request->getPayload()->getString('_token');
            if (!$this->isCsrfTokenValid('festivalId' . $festival->getId(), $submitedToken)) {
                throw new InvalidCsrfTokenException();
            }

            // Redirect to GET to show the form
            return $this->redirectToRoute('app_booking_form', ['id' => $festival->getId()]);
        }

        $booking = new Booking();
        $booking->setFestival($festival);
        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('booking/index.html.twig', [
            'form' => $form,
            'festival' => $festival,
        ]);
    }

    #[Route('/{id}', name: 'app_booking_form', methods: ['GET'])]
    public function showBookingForm(Festival $festival): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);

        return $this->render('booking/index.html.twig', [
            'form' => $form,
            'festival' => $festival,
        ]);
    }
}
