<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/category", name="category.")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories, 
            'page_title' => 'Category/List',
        ]);
    }

    /**
 * @Route("/create",name="create")
 */
public function create(Request $request, SluggerInterface $slugger)
{
    $category = new Category();
    $form = $this->createForm(CategoryType::class, $category);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
         $entityManager = $this->getDoctrine()->getManager();
         $entityManager->persist($category);
        $entityManager->flush();
        $this->addFlash('success', 'Category was created!'. $category->getId());
        return $this->redirect($this->generateUrl('category.index'));
    }

    return $this->render('category/create.html.twig', [
        'form' => $form->createView(),      
        'page_title' => 'Category/Create/Form',]);

}

   /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Category $category)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($category);

        $entityManager->flush();       
        
        $this->addFlash('success', 'Category was removed!'. $category->getId());

        return $this->redirect($this->generateUrl('category.index'));
    }

}
