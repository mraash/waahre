<?php

namespace App\Data\Entity;

use App\Data\Repository\ProductHorizonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductHorizonRepository::class)]
class ProductHorizon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'horizonLinks')]
    private Collection $productLinks;

    public function __construct()
    {
        $this->productLinks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProductLinks(): Collection
    {
        return $this->productLinks;
    }

    public function addProductLink(Product $productLink): static
    {
        if (!$this->productLinks->contains($productLink)) {
            $this->productLinks->add($productLink);
            $productLink->addHorizonLink($this);
        }

        return $this;
    }

    public function removeProductLink(Product $productLink): static
    {
        if ($this->productLinks->removeElement($productLink)) {
            $productLink->removeHorizonLink($this);
        }

        return $this;
    }
}
