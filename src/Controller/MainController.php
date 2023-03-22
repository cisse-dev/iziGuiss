<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(ProductRepository $repoProduct): Response

    {
        $products = $repoProduct->findAll();
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'products'=> $products
        ]);
    }
    #[Route('/politique_de_conf', name: 'rgpd')]
    public function affichergpd()
    {
     return $this->render('main/rgpd.html.twig');

    }
    

}
