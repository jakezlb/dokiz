<?php

namespace App\Controller;

use App\Entity\CarRide;
use App\Entity\Passenger;
use App\Entity\Status;

use App\Form\Type\CarRideType;
use App\Repository\CarRideRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/car_ride")
 */
class CarRideController extends AbstractController
{
    /**
     * @Route("/", name="car_ride_index", methods={"GET"})
     */
    public function index(CarRideRepository $carRideRepository): Response
    {
        return $this->render('car_ride/index.html.twig', [
            'car_rides' => $carRideRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="car_ride_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $carRide = new CarRide();
        $user = $this->getUser();        
        $form = $this->createForm(CarRideType::class, $carRide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $statusDefault = $entityManager->getRepository(Status::class)->findOneById(1);
            $carRide->setStatus($statusDefault);

            $entityManager->persist($carRide);
            $entityManager->flush();

            $passenger = new Passenger();
            $passenger->setCarRide($carRide);
            $passenger->setUser($user);
            $passenger->setIsDriver(1);
          
            $entityManager->persist($passenger);
            $entityManager->flush();

            return $this->redirectToRoute('car_ride_index');
        }

        return $this->render('car_ride/new.html.twig', [
            'car_ride' => $carRide,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="car_ride_show", methods={"GET"})
     */
    public function show(CarRide $carRide): Response
    {
        return $this->render('car_ride/show.html.twig', [
            'car_ride' => $carRide,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="car_ride_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CarRide $carRide): Response
    {
        $form = $this->createForm(CarRideType::class, $carRide);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('car_ride_index');
        }

        return $this->render('car_ride/edit.html.twig', [
            'car_ride' => $carRide,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="car_ride_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CarRide $carRide): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carRide->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($carRide);
            $entityManager->flush();
        }

        return $this->redirectToRoute('car_ride_index');
    }
}
