<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\CarRide;
use App\Entity\Reservation;
use App\Entity\User;
use App\Entity\Society;
use App\Form\Type\RoleType;
use App\Repository\UserRepository;
use App\Repository\SocietyRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="dashbord")
     */
    public function index()
    {
        $reservationRepo = $this->getDoctrine()->getRepository(Reservation::class);
        $carRepo = $this->getDoctrine()->getRepository(Car::class);

        /* graphique 1 */
        $reservationAllConfirmed = $reservationRepo->findAllConfirmed(true);
        $reservationAllNotConfirmed = $reservationRepo->findAllConfirmed(false);

        $nbReservationAllConfirmed = count($reservationAllConfirmed);
        $nbReservationAllNotConfirmed = count($reservationAllNotConfirmed);

        $ptReservationAllConfirmed = 0;
        $ptReservationAllNotConfirmed = 0;

        if (!empty($nbReservationAllConfirmed) || !empty($nbReservationAllNotConfirmed)) {
            $ptReservationAllConfirmed = $nbReservationAllConfirmed / ($nbReservationAllConfirmed + $nbReservationAllNotConfirmed) * 100;
            $ptReservationAllNotConfirmed = 100 - $ptReservationAllConfirmed;
        }

        $tabConfirmed = [];
        $tabNotConfirmed = [];

        $tabConfirmed['value'] = $nbReservationAllConfirmed;
        $tabConfirmed['pt'] = $ptReservationAllConfirmed;
        $tabNotConfirmed['value'] = $nbReservationAllNotConfirmed;
        $tabNotConfirmed['pt'] = $ptReservationAllNotConfirmed;
        /* fin graphique 1 */

        /* graphique 2 */
        $typeFuel = $carRepo->getFuel();
        $i = 0;

        $typeFuelTab = [];

        foreach ($typeFuel as $key => $type) {
            if ($key != 0) {
                if ($typeFuel[$key - 1]['fuel'] == $typeFuel[$key]['fuel']) {
                    if (!array_key_exists($type['fuel'], $typeFuelTab)) {
                        $typeFuelTab[$type['fuel']] = [];
                    }
                    array_push($typeFuelTab[$type['fuel']], $i++);
                } else {
                    if (!array_key_exists($type['fuel'], $typeFuelTab)) {
                        $typeFuelTab[$type['fuel']] = [];
                    }
                    array_push($typeFuelTab[$type['fuel']], $i++);
                }
            }
        }

        foreach ($typeFuelTab as $key => $type) {
            $typeFuelTab[$key]['value'] = count($type);
            $typeFuelTab[$key]['name'] = $key;
        }
        /* fin graphique 2 */

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'tabConfirmed' => $tabConfirmed,
            'tabNotConfirmed' => $tabNotConfirmed,
            'tabFuel' => $typeFuelTab
        ]);
    }

    /**
     * @Route("/utilisateurs", name="user_index", methods={"GET"})
     */
    public function usersList(UserRepository $UserRepository, UserInterface $user): Response
    {
        if($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPERADMIN')) {
            return $this->render('admin/user/index.html.twig', [
                'users' => $UserRepository->findAll(),
            ]);
        }else {
          
            return $this->render('admin/user/index.html.twig', [
                'users' => $UserRepository->findBySociety($user->getSociety()),
            ]);
        }
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserInterface $userConnect, SocietyRepository $SocietyRepository,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
     
        if(!$this->container->get('security.authorization_checker')->isGranted('ROLE_SUPERADMIN')) {
            $society = new Society();
            $society = $SocietyRepository->FindOneBy(['id' => $userConnect->getSociety()]);            
            $user->setSociety($society); 
        }   

        $form = $this->createForm(RoleType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->getData()->getPassword();
            $user->setPassword(
                $passwordEncoder->encodePassword($user, $password)
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('admin_user_index');
        }

        return $this->render('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/utilisateurs/modifier/{id}", name="user_edit")
     */
    public function editUser(User $user, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm(RoleType::class, $user, [
            'showPassword' => false
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setUpdatedAt(new \DateTime());
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('admin_user_index');
        }
        
        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}


