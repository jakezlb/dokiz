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

            $data = $form->getData();

            $email = $data->getEmail();
            dump($email);
            $message = (new Email())
            ->from('support@dokiz.com')
            ->to($email)
                ->subject('Changement du mot de passe')
                ->text('Pour réinitialiser votre mot de passe merci de cliquer sur le lien ci-dessous.')
                ;

            $mailer->send($message);
        }

        return $this->render('forgotPassword/forgotPassword.html.twig', [
            'form' => $form->createView()
        ]);
    }


}
