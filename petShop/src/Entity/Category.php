<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $animalType;

    /**
     * @ORM\OneToMany(targetEntity=CategorySubcategory::class, mappedBy="category")
     */
    private $categorySubcategories;

    public function __construct()
    {
        $this->categorySubcategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnimalType(): ?string
    {
        return $this->animalType;
    }

    public function setAnimalType(string $animalType): self
    {
        $this->animalType = $animalType;

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
            $categorySubcategory->setCategory($this);
        }

        return $this;
    }

    public function removeCategorySubcategory(CategorySubcategory $categorySubcategory): self
    {
        if ($this->categorySubcategories->removeElement($categorySubcategory)) {
            // set the owning side to null (unless already changed)
            if ($categorySubcategory->getCategory() === $this) {
                $categorySubcategory->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getAnimalType();
    }
}
