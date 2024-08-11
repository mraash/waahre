<?php

namespace App\Data\Entity;

use App\Data\Entity\ProductFRestaurant;
use App\Data\Entity\ProductHorizon;
use App\Data\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $orderName = null;

    /**
     * @var Collection<int, ProductFRestaurant>
     */
    #[ORM\ManyToMany(targetEntity: ProductFRestaurant::class, inversedBy: 'productLinks')]
    private Collection $frestaurantLinks;

    /**
     * @var Collection<int, ProductHorizon>
     */
    #[ORM\ManyToMany(targetEntity: ProductHorizon::class, inversedBy: 'productLinks')]
    private Collection $horizonLinks;

    public function __construct()
    {
        $this->frestaurantLinks = new ArrayCollection();
        $this->horizonLinks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

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

    public function getOrderName(): ?string
    {
        return $this->orderName ?? $this->name;
    }

    public function setOrderName(?string $orderName): static
    {
        $this->orderName = $orderName;

        return $this;
    }

    public function getHorizonTwin(): ?ProductHorizon
    {
        // TODO: throw new \RuntimeException('Replace method');
        return $this->getHorizonLinks()->first();
    }

    /**
     * @return Collection<int, ProductFRestaurant>
     */
    public function getFRestaurantTwins(): Collection
    {
        // TODO: throw new \RuntimeException('Replace method');
        return $this->getFrestaurantLinks();
    }

    /**
     * @return Collection<int, ProductHorizon>
     */
    public function getHorizonLinks(): Collection
    {
        return $this->horizonLinks;
    }

    public function addHorizonLink(ProductHorizon $horizonLink): static
    {
        if (!$this->horizonLinks->contains($horizonLink)) {
            $this->horizonLinks->add($horizonLink);
        }

        return $this;
    }

    public function removeHorizonLink(ProductHorizon $horizonLink): static
    {
        $this->horizonLinks->removeElement($horizonLink);

        return $this;
    }

    /**
     * @return Collection<int, ProductFRestaurant>
     */
    public function getFrestaurantLinks(): Collection
    {
        return $this->frestaurantLinks;
    }

    public function addFrestaurantLink(ProductFRestaurant $frestaurantLink): static
    {
        if (!$this->frestaurantLinks->contains($frestaurantLink)) {
            $this->frestaurantLinks->add($frestaurantLink);
        }

        return $this;
    }

    public function removeFrestaurantLink(ProductFRestaurant $frestaurantLink): static
    {
        $this->frestaurantLinks->removeElement($frestaurantLink);

        return $this;
    }
}
