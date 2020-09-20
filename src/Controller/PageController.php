<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PageController extends AbstractController
{
    /**
     * @Route("/privacy_policy", name="privacy_policy")
     */
    public function showPrivacyPolicy(Request $request): Response
    {

       return $this->render('confidentiality/privacy_policy.html.twig');
    }
     /**
     * @Route("/legal_notice", name="legal_notice")
     */
    public function showLegalNotice(Request $request): Response
    {

       return $this->render('confidentiality/legal_notice.html.twig');
    }
}