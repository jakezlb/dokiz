<?php

namespace App\Controller;

use App\Entity\KeyBox;
use App\Form\KeyBoxType;
use App\Repository\KeyBoxRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/key/box")
 */
class KeyBoxController extends AbstractController
{
    /**
     * @Route("/", name="key_box_index", methods={"GET"})
     */
    public function index(KeyBoxRepository $keyBoxRepository): Response
    {
        return $this->render('key_box/index.html.twig', [
            'key_boxes' => $keyBoxRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="key_box_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $keyBox = new KeyBox();
        $form = $this->createForm(KeyBoxType::class, $keyBox);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($keyBox);
            $entityManager->flush();

            return $this->redirectToRoute('key_box_index');
        }

        return $this->render('key_box/new.html.twig', [
            'key_box' => $keyBox,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="key_box_show", methods={"GET"})
     */
    public function show(KeyBox $keyBox): Response
    {
        return $this->render('key_box/show.html.twig', [
            'key_box' => $keyBox,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="key_box_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, KeyBox $keyBox): Response
    {
        $form = $this->createForm(KeyBoxType::class, $keyBox);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('key_box_index');
        }

        return $this->render('key_box/edit.html.twig', [
            'key_box' => $keyBox,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="key_box_delete", methods={"DELETE"})
     */
    public function delete(Request $request, KeyBox $keyBox): Response
    {
        if ($this->isCsrfTokenValid('delete'.$keyBox->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($keyBox);
            $entityManager->flush();
        }

        return $this->redirectToRoute('key_box_index');
    }
}
