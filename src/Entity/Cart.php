<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: Product::class)]
    private Collection $id_product;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $id_user = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\OneToMany(mappedBy: 'Panier', targetEntity: Product::class)]
    private Collection $product_id;

    public function __construct()
    {
        $this->id_product = new ArrayCollection();
        $this->product_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getIdProduct(): Collection
    {
        return $this->id_product;
    }

    public function addIdProduct(Product $idProduct): self
    {
        if (!$this->id_product->contains($idProduct)) {
            $this->id_product->add($idProduct);
            $idProduct->setCart($this);
        }

        return $this;
    }

    public function removeIdProduct(Product $idProduct): self
    {
        if ($this->id_product->removeElement($idProduct)) {
            // set the owning side to null (unless already changed)
            if ($idProduct->getCart() === $this) {
                $idProduct->setCart(null);
            }
        }

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): self
    {
        $this->id_user = $id_user;

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

    /**
     * @return Collection<int, Product>
     */
    public function getProductId(): Collection
    {
        return $this->product_id;
    }

    public function addProductId(Product $productId): self
    {
        if (!$this->product_id->contains($productId)) {
            $this->product_id->add($productId);
            $productId->setPanier($this);
        }

        return $this;
    }

    public function removeProductId(Product $productId): self
    {
        if ($this->product_id->removeElement($productId)) {
            // set the owning side to null (unless already changed)
            if ($productId->getPanier() === $this) {
                $productId->setPanier(null);
            }
        }

        return $this;
    }
}
