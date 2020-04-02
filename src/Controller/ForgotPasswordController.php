<?php

namespace App\Controller;

use App\Form\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

class ForgotPasswordController extends AbstractController
{
    /**
     * @Route("/forgotPassword", name="forgotPassword")
     */
    public function forgotPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder, MailerInterface $mailer)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $email = (new Email())
                ->from('dokiz')
                ->to($user->getEmail())
                ->subject('Bienvenue chez Dokiz !')
                ->text("Bienvenue chez Dokiz {$user->getFirstName()}");

            $mailer->send($email);
            
            return $this->redirect($this->generateUrl('app_login'));
        }

        return $this->render('forgotPassword/forgotPassword.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
