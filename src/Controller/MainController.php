<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
/**
 * @Route("/main")
 * @Route("/", name="home")
 */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', ['name'=> 'index testi' ]);
    }
/**
 * @Route("/test/{name?}", name="custom")
 * @param Request $request
 * @return Response
 */
    public function test(Request $request): Response
    {
        # dump($request->get('name'));
        $name = $request->get('name');
        return $this->render('home/custom.html.twig', ['name'=> $name ]);
    }
}
