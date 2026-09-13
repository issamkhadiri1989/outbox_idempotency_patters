<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['api:order:write', 'api:order:read'])]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $ownerOrder = null;

    #[ORM\Column]
    #[Groups(['api:order:write', 'api:order:read'])]
    private ?int $requestedQuantity = null;

    #[ORM\Column]
    #[Groups(['api:order:write', 'api:order:read'])]
    private ?float $unitPrice = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getOwnerOrder(): ?Order
    {
        return $this->ownerOrder;
    }

    public function setOwnerOrder(?Order $ownerOrder): static
    {
        $this->ownerOrder = $ownerOrder;

        return $this;
    }

    public function getRequestedQuantity(): ?int
    {
        return $this->requestedQuantity;
    }

    public function setRequestedQuantity(int $requestedQuantity): static
    {
        $this->requestedQuantity = $requestedQuantity;

        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): static
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }
}
