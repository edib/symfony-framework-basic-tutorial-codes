<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post", name="post.")
 * @param PostRepository $postRepository
 * @return Response
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(PostRepository $postRepository)
    {
        $posts = $postRepository->findAll();
        //dump($posts);
        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

/**
 * @Route("/create",name="create")
 */
    public function create(Request $request)
    {
        $post = new Post();
        $post->setTitle('This is going to be a title!');
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($post);

        $entityManager->flush();

        return new Response('Saved new product with id '.$post->getId());

    }

    /**
     * @Route("/show/{id}", name="show")
     * @param Post $post
     * 
     */
    public function show(Post $post)
    {
        return $this->render('post/show.html.twig', [
            'post' => $post
        ]);
    }
    
}
