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

class RegisterController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(MailerInterface $mailer, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $password = $data->getPassword();
            $user->setPassword(
                $passwordEncoder->encodePassword($user, $password)
            );

            $user->setCreatedAt(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

<<<<<<< HEAD
          /*  $email = (new Email())
                ->from('dokiz@gmail.com')
                ->to($user->getEmail())
                ->subject('Bienvenue chez Dokiz !')
                ->text("Bienvenue chez Dokiz {$user->getFirstName()}");

            $mailer->send($email);*/
=======
//            $email = (new Email())
//                ->from('dokiz@hotmail.fr')
//                ->to($user->getEmail())
//                ->subject('Bienvenue chez Dokiz !')
//                ->text("Bienvenue chez Dokiz {$user->getFirstName()}");

//            $mailer->send($email);
>>>>>>> 2d564cb3403b1f1d174ba3ee3c69aa16c041ff0d

            return $this->redirect($this->generateUrl('app_login'));
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
