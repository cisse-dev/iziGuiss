<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?User $id_user = null;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: Product::class)]
    private Collection $id_products;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\ManyToMany(targetEntity: Product::class)]
    private Collection $id_product_id;

    public function __construct()
    {
        $this->id_products = new ArrayCollection();
        $this->id_product_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Product>
     */
    public function getIdProducts(): Collection
    {
        return $this->id_products;
    }

    public function addIdProduct(Product $idProduct): self
    {
        if (!$this->id_products->contains($idProduct)) {
            $this->id_products->add($idProduct);
            $idProduct->setCommande($this);
        }

        return $this;
    }

    public function removeIdProduct(Product $idProduct): self
    {
        if ($this->id_products->removeElement($idProduct)) {
            // set the owning side to null (unless already changed)
            if ($idProduct->getCommande() === $this) {
                $idProduct->setCommande(null);
            }
        }

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
    public function getIdProductId(): Collection
    {
        return $this->id_product_id;
    }

    public function addIdProductId(Product $idProductId): self
    {
        if (!$this->id_product_id->contains($idProductId)) {
            $this->id_product_id->add($idProductId);
        }

        return $this;
    }

    public function removeIdProductId(Product $idProductId): self
    {
        $this->id_product_id->removeElement($idProductId);

        return $this;
    }
}
