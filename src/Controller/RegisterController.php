<?php

namespace App\Controller;

use App\Form\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $user = new User();
            $user->setLastName($data['lastName']);
            $user->setFirstName($data['firstName']);
            $user->setEmail($data['email']);
            $user->setPassword(
                $passwordEncoder->encodePassword($user, $data['password'])
            );

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('app_login'));
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
