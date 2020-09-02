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


class CarRideController extends AbstractController
{
    /**
     * @Route("admin/car_ride", name="admin_car_ride_index", methods={"GET"})
     */
    public function indexAdmin(CarRideRepository $carRideRepository): Response
    {
        return $this->render('admin/car_ride/index.html.twig', [
            'car_rides' => $carRideRepository->findAll(),
        ]);
    }

    /**
     * @Route("/car_ride", name="car_ride_index", methods={"GET"})
     * @param CarRideRepository $carRideRepository
     * @return Response
     */
    public function index(CarRideRepository $carRideRepository): Response
    {
        return $this->render('car_ride/index.html.twig', [
            'car_rides' => $carRideRepository->findAll(),
        ]);
    }

    /**
     * @Route("/car_ride/list", name="car_list", methods={"GET"})
     */
    public function rideByDate(CarRideRepository $carRideRepository): Response
    {
        return $this->render('car_ride/index.html.twig', [
            'carRides' => $carRideRepository->findByDate(),
        ]);
    }

    /**
     * @Route("car_ride/new", name="car_ride_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $carRide = new CarRide();
        $user = $this->getUser();        
        $form = $this->createForm(CarRideType::class, $carRide);
        $form->handleRequest($request);

        return $this->render('car_ride/new.html.twig', [
            'car_ride' => $carRide,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("car_ride/{id}", name="car_ride_show", methods={"GET"})
     */
    public function show(CarRide $carRide): Response
    {
        return $this->render('car_ride/show.html.twig', [
            'carRide' => $carRide,
        ]);
    }
     /**
     * @Route("admin/car_ride/{id}", name="admin_car_ride_show", methods={"GET"})
     */
    public function showAdmin(CarRide $carRide): Response
    {
        return $this->render('admin/car_ride/show.html.twig', [
            'car_ride' => $carRide,
        ]);
    }

    /**
     * @Route("car_ride/{id}/edit", name="car_ride_edit", methods={"GET","POST"})
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
     * @Route("car_ride/{id}", name="car_ride_delete", methods={"DELETE"})
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

    /**
     * @Route("car_ride/inscription", name="car_ride_inscription", methods={"POST"})
     */
    public function inscriptionCarRide(Request $request)
    {
        $data = $request->request->get('request');
        $entityManager = $this->getDoctrine()->getManager();
        dump($data);
        die;
    }
}
