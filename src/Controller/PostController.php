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
        $title = "";
        foreach (range(0, rand(5,10)) as $number) {
            $title .= $this->generateRandomString(rand(5,10))." ";
        }
        $post->setTitle($title);
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->persist($post);

        $entityManager->flush();

        $this->addFlash('success', 'Post was created!'. $post->getId());

        return $this->redirect($this->generateUrl('post.index'));

    }

    /**
     * @Route("/show/{id}", name="show")
     */
    public function show(Post $post)
    {
        return $this->render('post/show.html.twig', [
            'post' => $post
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Post $post)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($post);

        $entityManager->flush();       
        
        $this->addFlash('success', 'Post was removed!'. $post->getId());

        return $this->redirect($this->generateUrl('post.index'));
    }

    public function generateRandomString($length = 10) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

}
