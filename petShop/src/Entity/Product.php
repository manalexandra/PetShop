<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $inStock;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\OneToMany(targetEntity=ShoppingCartProduct::class, mappedBy="product")
     */
    private $shoppingCartProducts;

    /**
     * @ORM\OneToMany(targetEntity=OrderProduct::class, mappedBy="product")
     */
    private $orderProducts;

    /**
     * @ORM\ManyToOne(targetEntity=CategorySubcategory::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorySubcategory;


    public function __construct()
    {
        $this->shoppingCartProducts = new ArrayCollection();
        $this->orderProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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

    public function isInStock(): ?bool
    {
        return $this->inStock;
    }

    public function setInStock(bool $inStock): self
    {
        $this->inStock = $inStock;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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
            $shoppingCartProduct->setProduct($this);
        }

        return $this;
    }

    public function removeShoppingCartProduct(ShoppingCartProduct $shoppingCartProduct): self
    {
        if ($this->shoppingCartProducts->removeElement($shoppingCartProduct)) {
            // set the owning side to null (unless already changed)
            if ($shoppingCartProduct->getProduct() === $this) {
                $shoppingCartProduct->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OrderProduct>
     */
    public function getOrderProducts(): Collection
    {
        return $this->orderProducts;
    }

    public function addOrderProduct(OrderProduct $orderProduct): self
    {
        if (!$this->orderProducts->contains($orderProduct)) {
            $this->orderProducts[] = $orderProduct;
            $orderProduct->setProduct($this);
        }

        return $this;
    }

    public function removeOrderProduct(OrderProduct $orderProduct): self
    {
        if ($this->orderProducts->removeElement($orderProduct)) {
            // set the owning side to null (unless already changed)
            if ($orderProduct->getProduct() === $this) {
                $orderProduct->setProduct(null);
            }
        }

        return $this;
    }

    public function getCategorySubcategory(): ?CategorySubcategory
    {
        return $this->categorySubcategory;
    }

    public function setCategorySubcategory(?CategorySubcategory $categorySubcategory): self
    {
        $this->categorySubcategory = $categorySubcategory;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
