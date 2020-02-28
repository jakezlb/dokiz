<?php

namespace App\Controller;

use App\Entity\Passenger;
use App\Form\PassengerType;
use App\Repository\PassengerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/passenger")
 */
class PassengerController extends AbstractController
{
    /**
     * @Route("/", name="passenger_index", methods={"GET"})
     */
    public function index(PassengerRepository $passengerRepository): Response
    {
        return $this->render('passenger/index.html.twig', [
            'passengers' => $passengerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="passenger_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $passenger = new Passenger();
        $form = $this->createForm(PassengerType::class, $passenger);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($passenger);
            $entityManager->flush();

            return $this->redirectToRoute('passenger_index');
        }

        return $this->render('passenger/new.html.twig', [
            'passenger' => $passenger,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="passenger_show", methods={"GET"})
     */
    public function show(Passenger $passenger): Response
    {
        return $this->render('passenger/show.html.twig', [
            'passenger' => $passenger,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="passenger_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Passenger $passenger): Response
    {
        $form = $this->createForm(PassengerType::class, $passenger);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('passenger_index');
        }

        return $this->render('passenger/edit.html.twig', [
            'passenger' => $passenger,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="passenger_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Passenger $passenger): Response
    {
        if ($this->isCsrfTokenValid('delete'.$passenger->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($passenger);
            $entityManager->flush();
        }

        return $this->redirectToRoute('passenger_index');
    }
}
