<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/success', name: 'app_success')]
    public function success(Request $request, EntityManagerInterface $manager, UserRepository $userRepository, ProductRepository $productRepository): Response
    {
        // Récupération de l'utilisateur connecté
        $user = $this->getUser();

        // Récupération du produit correspondant à l'ID passé en paramètre de l'URL
        $product = $productRepository->find(11);
        $product2 = $productRepository->find(17);

        // Création d'une nouvelle commande
        $order = new Order();
        $order->addIdProductId($product);
        $order->addIdProductId($product2);
        $order->setIdUser($user);
        $order->setCreatedAt(new \DateTime());
        $order->setPrice(20);
        
        $this->addFlash('success', 'Votre oder a été enregistrée avec succès !');

        // Enregistrement de la commande en base de données
        $manager->persist($order);
        $manager->flush();

        return $this->render('stripe/success.html.twig');
    }

    #[Route('/admin/order', name: 'app_order_index', methods: ['GET'])]
    public function index(OrderRepository $orderRepository): Response
    {
        $orders = $orderRepository->findAll();
        
        return $this->render('order/index.html.twig', [
            'orders' => $orders,
        ]);   

    }
    
}
