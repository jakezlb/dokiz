<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/{id}", name="user")
     */
    public function index($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneById($id);

        return $this->render('user/index.html.twig', [
            'user' => $user,
        ]);
    }
}
