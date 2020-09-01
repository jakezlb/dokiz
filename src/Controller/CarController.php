<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Society;
use App\Form\Type\CarType;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\SocietyRepository;


/**
 * @Route("/admin/car", name="admin_")
 */
class CarController extends AbstractController
{
    /**
     * @Route("/", name="car_index", methods={"GET"})
     */
    public function index(CarRepository $carRepository, UserInterface $user): Response
    {
        
        if($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPERADMIN')) {
            return $this->render('admin/car/index.html.twig', [
                'cars' => $carRepository->findAll(),
            ]);
        }else {
            return $this->render('admin/car/index.html.twig', [
                'cars' => $carRepository->findBySociety($user->getSociety()),
            ]);           
        }
       
    }

    /**
     * @Route("/new", name="car_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger, UserInterface $userConnect, SocietyRepository $SocietyRepository): Response
    {
        $car = new Car();

        if(!$this->container->get('security.authorization_checker')->isGranted('ROLE_SUPERADMIN')) {
            $society = new Society();
            $society = $SocietyRepository->FindOneBy(['id' => $userConnect->getSociety()]);            
            $car->setSociety($society); 
        }   

        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carUrl = $form->get('car_url')->getData();

            if ($carUrl) {
           
                $originalFilename = pathinfo($carUrl->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$carUrl->guessExtension();
                try {
                    $carUrl->move(
                        $this->getParameter('car_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $car->setCarUrl($newFilename);              

            }

            $car->setStartReservationDate(new \DateTime());
            $car->setEndReservationDate(new \DateTime());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('admin_car_index');
        }

        return $this->render('admin/car/new.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="car_show", methods={"GET"})
     */
    public function show(Car $car): Response
    {
        return $this->render('admin/car/show.html.twig', [
            'car' => $car,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="car_edit", methods={"GET","POST"})
     */
    public function edit($id, Request $request, Car $car,  SluggerInterface $slugger): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        if (null === $car = $entityManager->getRepository(Car::class)->find($id)) {
            throw $this->createNotFoundException('No car found for id '.$id);
        }

        $originalKeys = new ArrayCollection();

        // Create an ArrayCollection of the current Key objects in the database
        foreach ($car->getKeys() as $key) {
                    
            $originalKeys->add($key);
        }
    
       
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
           
            foreach ($originalKeys as $key) {
                if (false === $car->getKeys()->contains($key)) {                   
               
                    // if it was a many-to-one relationship, remove the relationship like this
                    $key->setCar(null);   
                    
                    $entityManager->persist($key);

                    // if you wanted to delete the Tag entirely, you can also do that
                    $entityManager->remove($key);
    
                }
            }
            $carUrl = $form->get('car_url')->getData();
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($carUrl) {
                var_dump($carUrl);
                $originalFilename = pathinfo($carUrl->getClientOriginalName(), PATHINFO_FILENAME);
              
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$carUrl->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $carUrl->move(
                        $this->getParameter('car_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'carUrl' property to store the PDF file name
                // instead of its contents
                $car->setCarUrl($newFilename);              

            }
            $car->setStartReservationDate(new \DateTime());
            $car->setEndReservationDate(new \DateTime());

            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('admin_car_index');
           
        }

        return $this->render('admin/car/edit.html.twig', [
            'car' => $car,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="car_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Car $car): Response
    {
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($car);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_car_index');
    }
}
