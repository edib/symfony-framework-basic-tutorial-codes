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
 * @Route("/")
 */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MainController.php',
        ]);
    }
/**
 * @Route("/test/{name?}")
 * @param Request $request
 * @return Response
 */
    public function test(Request $request): Response
    {
        dump($request->get('name'));
        $name = $request->get('name');

        return new Response("<h1>Merbaha!</h1><h2>Merhaba $name</h2>");
    }
}
