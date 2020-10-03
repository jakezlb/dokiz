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
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use App\Repository\SocietyRepository;

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

            $user->setRoles(['ROLE_USER']);
            $user->setCreatedAt(new \DateTime());

            $email = (new TemplatedEmail())
                ->from('dokiz.entreprise@gmail.com')
                ->to($user->getEmail())
                ->subject('Bienvenue chez Dokiz !')
                ->htmlTemplate('emails/registrationInProgress.html.twig');
                
            $mailer->send($email);

            $emailInscription = $form->getData()->getEmail();
            $lastNameInscription = $form->getData()->getLastName();
            $firstNameInscription = $form->getData()->getFirstName();
            $phoneInscription = $form->getData()->getPhone();

            $email2 = (new TemplatedEmail())
            ->from('dokiz.entreprise@gmail.com')
            ->to('dokiz.entreprise@gmail.com')
            ->subject('Une nouvelle demande d\'inscription  !')
            ->htmlTemplate('emails/registrationNoAccepted.html.twig')
            ->context([
                'emailInscription' => $emailInscription, 
                'firstname' => $lastNameInscription,
                'lastname' => $firstNameInscription, 
                'phone' => $phoneInscription,
            ]);
            
            $mailer->send($email2);
            $em = $this->getDoctrine()->getManager();
            
            try {
                $em->persist($user);
                $em->flush();
                
                $this->addFlash('success', 'Votre demande d\'inscription a bien été prise en compte'); 
                return $this->redirect($this->generateUrl('app_login'));

            }
            catch(\Doctrine\DBAL\DBALException $e) 
            {
                $this->addFlash('danger', 'L\'adresse email est déjà utilisée');
                
            }           
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/register/society/{id}", name="register_society" , methods={"GET", "POST"})
     */
    public function registerBySociety($id, MailerInterface $mailer, Request $request, UserPasswordEncoderInterface $passwordEncoder, SocietyRepository $SocietyRepository)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

      
        $society = $SocietyRepository->findOneById($id);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $password = $data->getPassword();
            $user->setPassword(
                $passwordEncoder->encodePassword($user, $password)
            );
            $user->setSociety($society);
            $user->setRoles(['ROLE_USER']);
            $user->setCreatedAt(new \DateTime());

            $email = (new TemplatedEmail())
                ->from('dokiz.entreprise@gmail.com')
                ->to($user->getEmail())
                ->subject('Bienvenue chez Dokiz !')
                ->htmlTemplate('emails/registration.html.twig');
                
            $mailer->send($email);

            $em = $this->getDoctrine()->getManager();
            
            try {
                $em->persist($user);
                $em->flush();
                
                $this->addFlash('success', 'Votre demande d\'inscription a bien été prise en compte'); 
                return $this->redirect($this->generateUrl('app_login'));

            }
            catch(\Doctrine\DBAL\DBALException $e) 
            {
                $this->addFlash('danger', 'L\'adresse email est déjà utilisée');
                
            }

            return $this->redirect($this->generateUrl('app_login'));
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
