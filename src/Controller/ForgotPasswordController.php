<?php

namespace App\Controller;

use App\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/forgotPassword", name="forgotPassword", methods={"GET","POST"})
     */
    public function forgotPassword(Request $request) :Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $mailer = $this->get('mailer');
            $message = $mailer->createMessage()
                ->setFrom('dokiz.entreprise@gmail.com')
                ->setTo($data->getEmail())
                ->setSubject('Bienvenue chez Dokiz !');

            $mailer->send($message);
            
            return $this->redirect($this->generateUrl('app_login'));
        }

        return $this->render('forgotPassword/forgotPassword.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
