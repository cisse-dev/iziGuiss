<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




class CategoriesController extends AbstractController
{
    #[Route('/categories', name: 'app_categories')]
    public function index(CategoriesRepository $repoCategories, Request $request, EntityManagerInterface $manager): Response
    {
         $categories = $repoCategories->findAll();
                     
         $categories = new Categories;
         $form = $this->createForm(Categoriestype::class, $categories );

         $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($categories);
            $manager->flush(); 
        }

        return $this->render('categories/index.html.twig', [
            'controller_name' => 'CategoriesController',
            'categories' => $categories,
            'formCategories' => $form->createView()
        ]); 
    }
}