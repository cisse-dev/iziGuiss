<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    private ?int $categories = null;

    #[ORM\Column(length: 255)]
    private ?string $picture = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'id_product')]
    private ?Cart $cart = null;

    #[ORM\ManyToOne(inversedBy: 'id_products')]
    private ?Order $commande = null;

    #[ORM\ManyToOne(inversedBy: 'product_id')]
    private ?Cart $Panier = null;

    #[ORM\ManyToOne(inversedBy: 'id_product')]
    private ?Panier $panier = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Categories $FK_CATEGORY = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategories(): ?int
    {
        return $this->categories;
    }

    public function setCategories(int $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }

    public function getCommande(): ?Order
    {
        return $this->commande;
    }

    public function setCommande(?Order $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getPanier(): ?Cart
    {
        return $this->Panier;
    }

    public function setPanier(?Cart $Panier): self
    {
        $this->Panier = $Panier;

        return $this;
    }

    public function getFKCATEGORY(): ?Categories
    {
        return $this->FK_CATEGORY;
    }

    public function setFKCATEGORY(?Categories $FK_CATEGORY): self
    {
        $this->FK_CATEGORY = $FK_CATEGORY;

        return $this;
    }
}
