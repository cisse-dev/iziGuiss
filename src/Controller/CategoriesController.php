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
    #[Route('/admin/categories', name: 'app_categories')]
    public function index(CategoriesRepository $repoCategories, Request $request,
     EntityManagerInterface $manager): Response
    {
         $categories = $repoCategories->findAll();
                     
         $cat = new Categories;
         $form = $this->createForm(Categoriestype::class, $cat);

         $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($cat);
            $manager->flush(); 
        }

        return $this->render('categories/index.html.twig', [
            'controller_name' => 'CategoriesController',
            'categories' => $categories,
            'formCategories' => $form->createView()
        ]); 
    }
    // Update 
    #[Route('/admin/updateCategories/{id}', name: 'categories_update')]

    public function categories_update(Categories $categories, Request $request, EntityManagerInterface $manager)
    {

        $form = $this->createForm(CategoriesType::class, $categories);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($categories);
            $manager->flush();

            $this->addFlash("Succès", "Catégories " . $categories->getId() . "a bien été modifée");

            return $this->redirectToRoute('app_categories');
        }

        return $this->render("categories/updateCategories.html.twig", [
            "formCategories" => $form->createView(),
            "categories" => $categories
        ]);
    }
    // Delete 
    #[Route('/admin/DeleteCategories/{id}', name: 'categories_Delete')]

    public function categories_delete(Categories $categories, EntityManagerInterface $manager)
    {
        $idCategories = $categories->getId();

        $manager->remove($categories);
        $manager->flush();

            $this->addFlash("Succès", "Catégories " . $categories->getId() . "a bien été modifée");

            return $this->redirectToRoute('app_categories');
        
        
    }

    // Details 
    #[Route('/admin/detailscategories/{id}', name: 'categories_details')]

    public function categories_details(Categories $categories)
    {


        return $this->render("categories/detailsCategories.html.twig", [
            "categories" => $categories
        ]);
    }
   public function  __toString() {
       return $this->nom;
   }
   
    
}
