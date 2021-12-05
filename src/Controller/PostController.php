<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

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
     * @Route("/show/cat/{id}", name="show_cat")
     */
    public function show_cat($id, PostRepository $postRepository)
    {
        $posts = $postRepository->findPostByCategory($id);
        //dump($posts);
        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }


/**
 * @Route("/create",name="create")
 */
    public function create(Request $request, SluggerInterface $slugger)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
             $entityManager = $this->getDoctrine()->getManager();
            $file = $form->get('image')->getData();
            if ($file) {
                $safeFilename = $slugger->slug($file->getClientOriginalName());
                $filename = $safeFilename. "-".uniqid(). "." . $file->getClientOriginalExtension();
                $file->move(
                    $this->getParameter('upload_dir'),
                    $filename
                );
                $post->setImage($filename);
            }

             $entityManager->persist($post);
            $entityManager->flush();
            $this->addFlash('success', 'Post was created!'. $post->getId());
            return $this->redirect($this->generateUrl('post.index'));
        }

        return $this->render('post/create.html.twig', [
            'form' => $form->createView()]);

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
