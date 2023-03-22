<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe;

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

    #[Route('/stripe/create-charge', name: 'app_stripe_charge', methods: ['POST'])]
    public function createCharge(Request $request, CartService $cartService)
    {

        Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
       
        $cartTotal = $cartService->getCartTotal();
        Stripe\Charge::create([
            "amount" =>  $cartTotal * 100,
            // Montant du paiement en cents
            "currency" => "eur",
            // Devise
            "source" => $request->request->get('stripeToken'),
            // Token de la carte bancaire
            "description" => " Payment Test", // Description du paie
        ]);

        // Ajout d'un message flash pour indiquer que le paiement a été effectué avec succès
        $this->addFlash(
            'success',
            'Payment Successful!'
        );

        // Redirection vers la page principale après le paiement
        return $this->redirectToRoute('app_stripe', [], Response::HTTP_SEE_OTHER);
    }
}