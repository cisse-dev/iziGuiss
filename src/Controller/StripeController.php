<?php

namespace App\Controller;

use App\Entity\Order;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StripeController extends AbstractController
{
    private $privateKey;

    public function __construct()
    {
        // Configuration de la clé API Stripe
        if ($_ENV["APP_ENV"] === 'dev') {
            $this->privateKey = $_ENV["STRIPE_KEY"];
        } else {
            $this->privateKey = $_ENV["STRIPE_SECRET"];
        }
    }

    #[Route('/stripe', name: 'app_stripe')]
    public function index(): Response
    {
        return $this->render('stripe/index.html.twig', [
           
            'stripe_key' => $_ENV["STRIPE_KEY"],
        ]);
    }

    #[Route('/stripe/create-charge', name: 'app_stripe_charge')]
    public function createCharge(Request $request, CartService $cartService)
    {
        Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
        
        // Récupération du montant total du panier
        $cartTotal = $cartService->getCartTotal();
        
        // Création de la session Stripe avec le montant total du panier
        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $cartTotal * 100, // Le montant est en cents
                    'product_data' => [
                        'name' => 'Produits dans votre panier',
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('app_success', [], UrlGeneratorInterface::ABSOLUTE_URL),
            //'cancel_url' => $this->generateUrl('app_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ]);
        $order = new Order();
        // Redirection vers la page de paiement Stripe
        return $this->redirect($checkout_session->url);
    }
}    