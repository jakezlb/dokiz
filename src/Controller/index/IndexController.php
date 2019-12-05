<?php

namespace App\Controller\index;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $title = 'DOKIZ';

        return $this->render('index/index.html.twig',
            ['title' => $title]);
    }
}
