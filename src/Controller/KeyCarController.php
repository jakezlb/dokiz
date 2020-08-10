<?php

namespace App\Controller;

use App\Entity\KeyCar;
use App\Form\Type\KeyCarType;
use App\Repository\KeyCarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/key_car" , name="admin_")
 */
class KeyCarController extends AbstractController
{
    /**
     * @Route("/", name="key_car_index", methods={"GET"})
     */
    public function index(KeyCarRepository $keyCarRepository): Response
    {
        return $this->render('admin/key_car/index.html.twig', [
            'key_cars' => $keyCarRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="key_car_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $keyCar = new KeyCar();
        $form = $this->createForm(KeyCarType::class, $keyCar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $keyCar->setIsTaken(0);
            $entityManager = $this->getDoctrine()->getManager();            
            $entityManager->persist($keyCar);
            $entityManager->flush();

            return $this->redirectToRoute('admin_key_car_index');
        }

        return $this->render('admin/key_car/new.html.twig', [
            'key_car' => $keyCar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="key_car_show", methods={"GET"})
     */
    public function show(KeyCar $keyCar): Response
    {
        return $this->render('admin/key_car/show.html.twig', [
            'key_car' => $keyCar,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="key_car_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, KeyCar $keyCar): Response
    {
        $form = $this->createForm(KeyCarType::class, $keyCar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_key_car_index');
        }

        return $this->render('admin/key_car/edit.html.twig', [
            'key_car' => $keyCar,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="key_car_delete", methods={"DELETE"})
     */
    public function delete(Request $request, KeyCar $keyCar): Response
    {
        if ($this->isCsrfTokenValid('delete'.$keyCar->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($keyCar);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_key_car_index');
    }
}
