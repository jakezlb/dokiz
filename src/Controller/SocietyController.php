<?php

namespace App\Controller;

use App\Entity\Society;
use App\Form\Type\SocietyType;
use App\Repository\SocietyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;

/**
 * @Route("/admin/society" , name="admin_")
 */
class SocietyController extends AbstractController
{
    /**
     * @Route("/", name="society_index", methods={"GET"})
     */
    public function index(SocietyRepository $societyRepository): Response
    {
        return $this->render('admin/society/index.html.twig', [
            'societies' => $societyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="society_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $society = new Society();
        $form = $this->createForm(SocietyType::class, $society);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($society);
            $entityManager->flush();

            return $this->redirectToRoute('admin_society_index');
        }

        return $this->render('admin/society/new.html.twig', [
            'society' => $society,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="society_show", methods={"GET"})
     */
    public function show(Society $society): Response
    {
        return $this->render('admin/society/show.html.twig', [
            'society' => $society,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="society_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Society $society): Response
    {
        $form = $this->createForm(SocietyType::class, $society);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_society_index');
        }

        return $this->render('admin/society/edit.html.twig', [
            'society' => $society,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="society_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Society $society): Response
    {
        try{                 
            if ($this->isCsrfTokenValid('delete'.$society->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($society);
                $entityManager->flush();
                $this->addFlash('success', 'La scoiété à bien été supprimé');                
            }
        }catch(ForeignKeyConstraintViolationException $e){            
            $this->addFlash('danger', 'Impossible de supprimer la société elle est déjà attribuée à des utilisateurs et des véhicules. Veuillez supprimer tous les utilisateurs et les véhicules reliés à cette société avant de renouveler cette opération.');
        }

        return $this->redirectToRoute('admin_society_index');
    }
}
