<?php

namespace App\Controller;

use App\Entity\CarRide;
use App\Entity\Passenger;
use App\Entity\Reservation;
use App\Entity\Society;
use App\Entity\Status;

use App\Form\Type\CarRideType;
use App\Repository\CarRideRepository;
use App\Repository\PassengerRepository;
use App\Repository\SocietyRepository;
use App\Repository\UserRepository;
use Proxies\__CG__\App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;



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
    public function index(CarRideRepository $carRideRepository, UserInterface $user): Response
    {

        return $this->render('car_ride/index.html.twig', [
            'car_rides' => $carRideRepository->findBySociety($user->getSociety()),
        ]);
    }

    /**
     * @Route("/car_ride/list", name="car_list", methods={"GET"})
     */
    public function rideByDate(CarRideRepository $carRideRepository, SocietyRepository $societyRepository, UserInterface $user): Response
    {
        $societyTempo = $user->getSociety();
        if($societyTempo==null){
            return $this->redirectToRoute('index');
        }
        $idSociety = $societyTempo->getId();
        $society = $societyRepository->find($idSociety);
        return $this->render('car_ride/index.html.twig', [
            'carRides' => $carRideRepository->findBySociety($society),
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
    public function delete(MailerInterface $mailer, Request $request, CarRide $carRide, UserInterface $userInterface): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $idResa = $carRide->getReservation();
       
        $start_reservation_date =  ($carRide->getDateStart())->format('d-m-Y H:i:s');
        $end_reservation_date =  ($carRide->getDateEnd())->format('d-m-Y H:i:s');
     
        $passengers = $carRide->getPassengers();  
        $emailUser = $userInterface->getEmail();       

        if(!empty($passengers)) {       
            foreach ($passengers as $passenger) {
                $passengerEmail = $passenger->getUser()->getEmail();                                    
                $email = (new TemplatedEmail())
                ->from('dokiz.entreprise@gmail.com')
                ->to($passengerEmail)
                ->subject('Annulation de votre réservation')
                ->htmlTemplate('emails/cancelReservation.html.twig')
                ->context([                
                    'start_reservation_date' => $start_reservation_date,
                    'end_reservation_date'=> $end_reservation_date,                
                ]);
                $mailer->send($email);
                
            }
            $email = (new TemplatedEmail())
                ->from('dokiz.entreprise@gmail.com')
                ->to($emailUser)
                ->subject('Annulation de votre réservation')
                ->htmlTemplate('emails/cancelReservationByDriver.html.twig')
                ->context([                
                    'start_reservation_date' => $start_reservation_date,
                    'end_reservation_date'=> $end_reservation_date,                
                ]);
            $mailer->send($email);

            $this->addFlash('success', 'Votre trajet a bien été annulé. Vous allez reçevoir un email de confirmation. L\'ensemble des passagers vont également être averti de votre annulation');

        }else{            
            $email = (new TemplatedEmail())
                ->from('dokiz.entreprise@gmail.com')
                ->to($emailUser)
                ->subject('Annulation de votre réservation')
                ->htmlTemplate('emails/cancelReservationByDriver.html.twig')
                ->context([                
                    'start_reservation_date' => $start_reservation_date,
                    'end_reservation_date'=> $end_reservation_date,                
                ]);
            $mailer->send($email);
            $this->addFlash('success', 'Votre trajet a bien été annulé. Vous allez reçevoir un email de confirmation.');
        }        
       
        $entityManager->remove($carRide);
        $entityManager->flush();

        $reservation = $entityManager->getRepository(Reservation::class)->findOneById($idResa->getId());

        if($reservation->getCarRides()->count() < 1) {
            return $this->redirectToRoute('reservation_delete',array('id' => $reservation->getId()));
        } else {
            return $this->redirectToRoute('car_list');
        }
    }

    /**
     * @Route("car_ride/inscription", name="car_ride_inscription", methods={"POST"})
     */
    public function inscriptionCarRide(Request $request, CarRideRepository $carRideRepository, PassengerRepository $passengerRepository, UserRepository $userRepository)
    {
        $idUser = $request->request->get('idUser');
        $user = $userRepository->find($idUser);

        $idCarRide = $request->request->get('id');
        $carRide = $carRideRepository->find($idCarRide);

        $entityManager = $this->getDoctrine()->getManager();
            $passenger = new Passenger();
            $passenger->setIsDriver(false);
            $passenger->setUser($user);
            $passenger->setCarRide($carRide);
            $entityManager->persist($passenger);
            $entityManager->flush();



        return $this->json("OK");
    }

    /**
     * @Route("car_ride/desinscription", name="car_ride_desinscription", methods={"POST"})
     */
    public function desinscriptionCarRide(Request $request, CarRideRepository $carRideRepository, PassengerRepository $passengerRepository, UserRepository $userRepository)
    {
        $idUser = $request->request->get('idUser');
        $user = $userRepository->find($idUser);

        $idCarRide = $request->request->get('id');
        $carRide = $carRideRepository->find($idCarRide);

        $entityManager = $this->getDoctrine()->getManager();
            $passenger = new Passenger();
            $passengers = $carRide->getPassengers();
            foreach ($passengers as $passengerTempo ){
                if($passengerTempo->getUser()==$user) $passenger = $passengerTempo;
            }
            $entityManager->remove($passenger);
            $entityManager->flush();


        return $this->json("OK");
    }
}
