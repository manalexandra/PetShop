<?php

namespace App\Entity;

use App\Repository\ShoppingCartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShoppingCartRepository::class)
 */
class ShoppingCart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="shoppingCarts")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=ShoppingCartProduct::class, mappedBy="shoppingCart")
     */
    private $shoppingCartProducts;

    public function __construct()
    {
        $this->shoppingCartProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, ShoppingCartProduct>
     */
    public function getShoppingCartProducts(): Collection
    {
        return $this->shoppingCartProducts;
    }

    public function addShoppingCartProduct(ShoppingCartProduct $shoppingCartProduct): self
    {
        if (!$this->shoppingCartProducts->contains($shoppingCartProduct)) {
            $this->shoppingCartProducts[] = $shoppingCartProduct;
            $shoppingCartProduct->setShoppingCart($this);
        }

        return $this;
    }

    public function removeShoppingCartProduct(ShoppingCartProduct $shoppingCartProduct): self
    {
        if ($this->shoppingCartProducts->removeElement($shoppingCartProduct)) {
            // set the owning side to null (unless already changed)
            if ($shoppingCartProduct->getShoppingCart() === $this) {
                $shoppingCartProduct->setShoppingCart(null);
            }
        }

        return $this;
    }
}
