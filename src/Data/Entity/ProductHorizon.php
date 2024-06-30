<?php

namespace App\Data\Entity;

use App\Data\Repository\ProductHorizonRepository;
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

    #[ORM\OneToOne(mappedBy: 'horizonTwin', cascade: ['persist', 'remove'])]
    private ?Product $localTwin = null;

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

    public function getLocalTwin(): ?Product
    {
        return $this->localTwin;
    }

    public function setLocalTwin(Product $localTwin): static
    {
        // set the owning side of the relation if necessary
        if ($localTwin->getHorizonTwin() !== $this) {
            $localTwin->setHorizonTwin($this);
        }

        $this->localTwin = $localTwin;

        return $this;
    }
}
