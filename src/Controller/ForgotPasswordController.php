<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\ResetPassType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ForgotPasswordController extends AbstractController
{
    /**
     * @Route("/forgotPassword", name="forgotPassword", methods={"GET","POST"})
     */
    public function forgotPassword(MailerInterface $mailer, Request $request, UserRepository $user, TokenGeneratorInterface $tokenGenerator) :Response
    {
        $form = $this->createForm(ResetPassType::class);
        $form->handleRequest($request);

        

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $user = $user->findOneByEmail($data['email']);
           
            if ($user === null) {
                $this->addFlash('danger', 'L\'adresse email n\'existe pas');               
                return $this->redirectToRoute('app_login');
            }

            $token = $tokenGenerator->generateToken();
            try {
                $user->setResetToken($token);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $this->addFlash('success', 'Un email vous a été envoyé afin de réinitialiser votre mot de passe');
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('app_login');
            }

            $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            $email = (new TemplatedEmail())
                ->from('dokiz.entreprise@gmail.com')
                ->to($user->getEmail())
                ->subject('Mot de passe oublié')
                ->htmlTemplate("emails/forgetPassword.html.twig")
                ->context([
                    'url' => $url,
                ]);

            $mailer->send($email);         

            return $this->redirectToRoute('app_login');
        }
        return $this->render('forgotPassword/forgotPassword.html.twig', ['emailForm' => $form->createView()]);
    }

    /**
     * @Route("/resetPass/{token}", name="app_reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['resetToken' => $token]);

        if ($user === null) {
            return $this->redirectToRoute('app_login');
        }

        if ($request->isMethod('POST')) {
            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_login');
        } else {
            return $this->render('forgotPassword/resetPassword.html.twig', ['token' => $token]);
        }
    }
}
