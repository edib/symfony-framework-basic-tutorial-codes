<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoloController extends AbstractController
{
    /**
     * @Route("/lolo", name="lolo")
     */
    public function index(): Response
    {
        return $this->render('lolo/index.html.twig', [
            'controller_name' => 'LoloController',
        ]);
    }
}
