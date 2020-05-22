<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\RoleType;
use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/utilisateurs", name="utilisateurs", methods={"GET"})
     */
    public function usersList(UserRepository $users): Response
    {
        return $this->render('admin/show.html.twig', [
            'users' => $users->findAll(),
        ]);
    }

    /**
     * @Route("/utilisateurs/modifier/{id}", name="modifier_utilisateur")
     */
    public function editUser(User $user, Request $request)
    {
        $form = $this->createForm(RoleType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('admin_utilisateurs');
        }
        
        return $this->render('admin/user/edit.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }
}


