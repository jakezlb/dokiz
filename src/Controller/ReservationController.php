<?php

namespace App\Controller;

use App\Entity\CarRide;
use App\Entity\Passenger;
use App\Entity\Reservation;
use App\Entity\Status;
use App\Form\Type\CarRideType;
use App\Form\Type\CarType;
use App\Form\Type\ReservationType;
use App\Repository\CarRepository;
use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;


class ReservationController extends AbstractController
{

    /**
     * @Route("reservation", name="reservation_index", methods={"GET"})
     * @param ReservationRepository $reservationRepository
     * @return Response
     */
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
        
    }

    /**
     * @Route("admin/reservation", name="admin_reservation_index", methods={"GET"})
     * @param ReservationRepository $reservationRepository
     * @return Response
     */
    public function indexAdmin(ReservationRepository $reservationRepository, UserInterface $user): Response
    {
        if($this->denyAccessUnlessGranted('ROLE_ADMIN')) {
            return $this->render('admin/reservation/index.html.twig', [
                'reservations' => $reservationRepository->findAll(),
            ]);
        }else {
          
            return $this->render('admin/reservation/index.html.twig', [
                'reservations' => $reservationRepository->findBySociety($user->getSociety()),
            ]);
        }
    }

    /**
     * @Route("/reservation/user/{id}", name="reservation_user", methods={"GET"})
     * @param ReservationRepository $reservationRepository
     * @param int $id
     * @return Response
     * @throws \Doctrine\DBAL\DBALException
     */
    public function indexById(ReservationRepository $reservationRepository, int $id): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findByUser($id),
        ]);
    }

    /**
     * @Route("/reservation/new", name="reservation_new", methods={"GET","POST"})
     * @param CarRepository $carRepository
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function new(CarRepository $carRepository, Request $request): Response
    {
        $reservation = new Reservation();
        $carRide1 = new CarRide();
        $reservation->getCarRides()->add($carRide1);
        $carRide2 = new CarRide();
        $reservation->getCarRides()->add($carRide2);

        $cars = $carRepository->findAll();

        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $cars = $request->request->get('cars');
            $carExplode = explode(" - ", $cars);
            $car = $carRepository->find($carExplode[0]);
            $car->setStartReservationDate($carRide1->getDateStart());
            $car->setEndReservationDate($carRide2->getDateEnd());

            $reservation->setIsConfirmed(false);
            $reservation->setDateReservation(new \DateTime());

            $statusDefault = $entityManager->getRepository(Status::class)->findOneById(2);
            $carRide1->setStatus($statusDefault);
            $carRide1->setReservation($reservation);

            $carRide2->setStatus($statusDefault);
            $carRide2->setReservation($reservation);

            $user = $this->getUser();

            $passenger1 = new Passenger();
            $passenger1->setCarRide($carRide1);
            $passenger1->setUser($user);
            $passenger1->setIsDriver(1);

            $passenger2 = new Passenger();
            $passenger2->setCarRide($carRide2);
            $passenger2->setUser($user);
            $passenger2->setIsDriver(1);

            $reservation->setUser($user);
            $reservation->setCar($car);

            $entityManager->persist($reservation);
            $entityManager->flush();

            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('reservation_index');
        }

        return $this->render('reservation/new.html.twig', array(
            'form' => $form->createView(),
            'cars' => $cars
        ));
    }

    /**
     * @Route("/reservation/{id}", name="reservation_show", methods={"GET"})
     * @param Reservation $reservation
     * @return Response
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * @Route("/reservation/{id}", name="reservation_delete", methods={"DELETE"})
     * @param Request $request
     * @param Reservation $reservation
     * @return Response
     */
    public function delete(Request $request, Reservation $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservation_index');
    }
}
