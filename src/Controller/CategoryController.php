<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findBy([],['name'=>'ASC']);
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categories'=>$categories,
        ]);
    }

    #[Route('/category/new', name: 'category.new')]
    #[Route('/category/edit-{id}', name: 'category.edit',requirements : ['id'=>'\d+'])]
    public function new(Category $category = null,Request $request,EntityManagerInterface $em): Response
    {
        if (!$category) {
            $category = new Category();
        }

        $form = $this->createForm(CategoryType::class , $category);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid() ) {
            $newCategory= $form->getData();
            $em->persist($newCategory);
            $em->flush();
            $this->addFlash('success','Vous avez bien ajouté une nouvelle catégorie !');
            return $this->redirectToRoute('app_category');
        }

        return $this->render('category/new.html.twig', [
            'controller_name' => 'CategoryController',
            'form'=>$form,
        ]);
    }

    #[Route('/category/show-{id}', name: 'category.show',requirements : ['id'=>'\d+'])]
    public function show(Category $category,CategoryRepository $categoryRepository): Response
    {
        
        return $this->render('category/show.html.twig', [
            'controller_name' => 'CategoryController',
            'category'=>$category,
        ]);
    }
}
