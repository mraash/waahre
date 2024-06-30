<?php

namespace App\Data\Entity;

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

    #[ORM\Column(length: 255)]
    private ?string $orderName = null;

    #[ORM\OneToOne(inversedBy: 'localTwin', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?ProductHorizon $horizonTwins = null;

    /**
     * @var Collection<int, ProductFRestaurant>
     */
    #[ORM\OneToMany(targetEntity: ProductFRestaurant::class, mappedBy: 'localTwin')]
    private Collection $fRestaurantTwin;

    public function __construct()
    {
        $this->fRestaurantTwin = new ArrayCollection();
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
        return $this->orderName;
    }

    public function setOrderName(string $orderName): static
    {
        $this->orderName = $orderName;

        return $this;
    }

    public function getHorizonTwin(): ?ProductHorizon
    {
        return $this->horizonTwins;
    }

    public function setHorizonTwin(ProductHorizon $horizonTwin): static
    {
        $this->horizonTwins = $horizonTwin;

        return $this;
    }

    /**
     * @return Collection<int, ProductFRestaurant>
     */
    public function getFRestaurantTwins(): Collection
    {
        return $this->fRestaurantTwin;
    }

    public function addFRestaurantTwin(ProductFRestaurant $fRestaurantTwin): static
    {
        if (!$this->fRestaurantTwin->contains($fRestaurantTwin)) {
            $this->fRestaurantTwin->add($fRestaurantTwin);
            $fRestaurantTwin->setLocalTwin($this);
        }

        return $this;
    }

    public function removeFRestaurantTwin(ProductFRestaurant $fRestaurantTwin): static
    {
        if ($this->fRestaurantTwin->removeElement($fRestaurantTwin)) {
            // set the owning side to null (unless already changed)
            if ($fRestaurantTwin->getLocalTwin() === $this) {
                $fRestaurantTwin->setLocalTwin(null);
            }
        }

        return $this;
    }
}
