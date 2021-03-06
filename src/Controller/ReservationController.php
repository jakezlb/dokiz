<?php

namespace App\Controller;

use App\Entity\CarRide;
use App\Entity\Passenger;
use App\Entity\Reservation;
use App\Entity\Status;
use App\Form\Type\ReservationType;
use App\Repository\CarRepository;
use App\Repository\ReservationRepository;
use App\Repository\SocietyRepository;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


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
        if($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPERADMIN')) {
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
        $carRide = $this->getDoctrine()->getRepository(CarRide::class)
            ->findByUser($id);
        return $this->render('reservation/index.html.twig', [
            'carRides' => $carRide,
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
    public function new(MailerInterface $mailer, CarRepository $carRepository, SocietyRepository $societyRepository, UserInterface $userInterface, Request $request): Response
    {
        $reservation = new Reservation();
        $carRide1 = new CarRide();
        $carRide2 = new CarRide();
        $reservation->getCarRides()->add($carRide1);
        $reservation->getCarRides()->add($carRide2);
        

        $societyTempo = $userInterface->getSociety();
        $idSociety = $societyTempo->getId();
        $society = $societyRepository->find($idSociety);

        $cars = $carRepository->findBySociety($society);
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {        
           

            $switchButton = $request->request->get('customSwitches');
            $switchButton = boolval($switchButton);

            $entityManager = $this->getDoctrine()->getManager();

            $cars = $request->request->get('cars');
            $cars = str_replace("car","",$cars);
            $car = $carRepository->find($cars);
            $car->setStartReservationDate($carRide1->getDateStart());

            $reservation->setIsConfirmed(false);
            $reservation->setDateReservation(new \DateTime());

            $statusDefault = $entityManager->getRepository(Status::class)->findOneById(1);
            $carRide1->setStatus($statusDefault);
            $carRide1->setReservation($reservation);

            $user = $this->getUser();

            if ($switchButton != true) {
                $car->setEndReservationDate($carRide1->getDateEnd());
                $reservation->getCarRides()->remove($reservation->getCarRides()->count() -1 );
            } else {
                $car->setEndReservationDate($carRide2->getDateEnd());
                $carRide2->setStatus($statusDefault);
                $carRide2->setReservation($reservation);
            }

            $reservation->setUser($user);
            $reservation->setCar($car);

            $firstName = $userInterface->getFirstName();
            $lastName = $userInterface->getLastName();
            $phone = $userInterface->getPhone();
            $emailUser = $userInterface->getEmail();
            $emailInterlocutor = $society->getEmailInterlocutor();
            $start_reservation_date = ($carRide1->getDateStart())->format('d-m-Y H:i:s');
            $end_reservation_date = $carRide2->getDateEnd() != '' ? ($carRide2->getDateEnd())->format('d-m-Y H:i:s') : ($carRide1->getDateEnd())->format('d-m-Y H:i:s');

            $email = (new TemplatedEmail())
            ->from('dokiz.entreprise@gmail.com')
            ->to($emailInterlocutor)
            ->subject('Nouvelle réservation')
            ->htmlTemplate('emails/newReservation.html.twig')
            ->context([
                'firstName' => $firstName, 
                'lastName' => $lastName,
                'phone' => $phone,
                'emailUser'=> $emailUser,
                'start_reservation_date' => $start_reservation_date,
                'end_reservation_date'=> $end_reservation_date,
            ]);

            $mailer->send($email);

            $mark = $car->getMark();
            $immatriculation = $car->getImmatriculation();
            $fuel = $car->getFuel();
            $parked = $car->getParked();           
            $telInterlocutor = $society->getTelInterlocutor();

            $email2 = (new TemplatedEmail())
            ->from('dokiz.entreprise@gmail.com')
            ->to($emailUser)
            ->subject('Votre réservation')
            ->htmlTemplate('emails/confirmationReservation.html.twig')
            ->context([
                'mark' => $mark, 
                'immatriculation' => $immatriculation,
                'fuel' => $fuel,
                'parked'=> $parked,
                'start_reservation_date' => $start_reservation_date,
                'end_reservation_date'=> $end_reservation_date,
                'phoneInterlocutor' => $telInterlocutor,
            ]);

            $mailer->send($email2);

            $entityManager->persist($reservation);
            $entityManager->flush();

            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('car_list');
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
     * @Route("/reservation/delete/{id}", name="reservation_delete", methods={"GET", "POST"})
     * @param Request $request
     * @param Reservation $reservation
     * @return Response
     */
    public function delete(Request $request, Reservation $reservation): Response
    {       
  
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reservation);
        $entityManager->flush();

        return $this->redirectToRoute('car_list');
    }
}
