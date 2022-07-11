<?php

namespace App\Entity;

use App\Repository\SubcategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubcategoryRepository::class)
 */
class Subcategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="subcategory")
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity=CategorySubcategory::class, mappedBy="subcategory")
     */
    private $categorySubcategories;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->categorySubcategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, CategorySubcategory>
     */
    public function getCategorySubcategories(): Collection
    {
        return $this->categorySubcategories;
    }

    public function addCategorySubcategory(CategorySubcategory $categorySubcategory): self
    {
        if (!$this->categorySubcategories->contains($categorySubcategory)) {
            $this->categorySubcategories[] = $categorySubcategory;
            $categorySubcategory->setSubcategory($this);
        }

        return $this;
    }

    public function removeCategorySubcategory(CategorySubcategory $categorySubcategory): self
    {
        if ($this->categorySubcategories->removeElement($categorySubcategory)) {
            // set the owning side to null (unless already changed)
            if ($categorySubcategory->getSubcategory() === $this) {
                $categorySubcategory->setSubcategory(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
