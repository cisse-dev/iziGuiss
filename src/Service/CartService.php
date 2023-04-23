<?php

namespace App\Service;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private RequestStack $requestStack;
    private EntityManagerInterface $em;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
    {
        $this->requestStack = $requestStack;
        $this->em = $em;
    }

    public function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }

    public function addCart(int $id)
    {
        $cart = $this->getSession()->get('cart', []);

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $this->getSession()->set('cart', $cart);
    }

    public function getCartData()
    {
        $cart = $this->getSession()->get('cart');
        $cartData = [];

        if ($cart) {
            foreach ($cart as $id => $q) {
                $fetchProduits = $this->em->getRepository(Product::class)->findOneBy(['id' => $id]);

                if ($fetchProduits) {
                    $cartData[] = [
                        'product' => $fetchProduits,
                        'quantity' => $q
                    ];
                }
            }
        }

        return $cartData;
    }

    public function getCartTotal()
    {
        $cart = $this->getSession()->get('cart');
        $cartData = [];
        $total = 0;

        if ($cart) {
            foreach ($cart as $id => $q) {
                $fetchProduits = $this->em->getRepository(Product::class)->findOneBy(['id' => $id]);

                if ($fetchProduits) {
                    $cartData[] = [
                        'product' => $fetchProduits,
                        'quantity' => $q
                    ];
                    $total += $fetchProduits->getPrice();
                }
            }
        }

        return $total;
    }

    public function deleteCart(int $id)
    {
        $cart = $this->getSession()->get('cart', []);

        unset($cart[$id]);
        return $this->getSession()->set('cart', $cart);
    }

    public function deleteAllCart()
    {
        return $this->getSession()->remove('cart');
    }

    public function decrease(int $id)
    {
        $cart = $this->getSession()->get('cart', []);

        if ($cart[$id] > 1) {
            $cart[$id]--;
        } else {
            unset($cart[$id]);
        }

        return $this->getSession()->set('cart', $cart);
    }

    public function getCartItems()
    {
        return $this->getSession()->get('cart', []);
    }
}
