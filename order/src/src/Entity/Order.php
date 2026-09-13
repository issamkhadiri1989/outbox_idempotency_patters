<?php

namespace App\Entity;

use ApiPlatform\Metadata\Post;
use App\Enum\OrderStatus;
use App\Repository\OrderRepository;
use App\State\Processor\OrderPrecessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`orders`')]
#[ORM\HasLifecycleCallbacks]
#[Post(
    denormalizationContext: ['groups' => ['api:order:write']],
    normalizationContext: ['groups' => ['api:order:read']],
    processor: OrderPrecessor::class,
)]
class Order
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[Groups(['api:order:read'])]
    private ?Uuid $id = null;

    #[ORM\Column]
    #[Groups(['api:order:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['api:order:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true, enumType: OrderStatus::class)]
    #[Groups(['api:order:read'])]
    private ?OrderStatus $status = null;

    /**
     * @var Collection<int, OrderItem>
     */
    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'ownerOrder', orphanRemoval: true, cascade: ['persist', 'remove'])]
    #[Groups(['api:order:write', 'api:order:read'])]
    private Collection $orderItems;

    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getStatus(): ?OrderStatus
    {
        return $this->status;
    }

    public function setStatus(?OrderStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, OrderItem>
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    public function addOrderItem(OrderItem $orderItem): static
    {
        if (!$this->orderItems->contains($orderItem)) {
            $this->orderItems->add($orderItem);
            $orderItem->setOwnerOrder($this);
        }

        return $this;
    }

    public function removeOrderItem(OrderItem $orderItem): static
    {
        if ($this->orderItems->removeElement($orderItem)) {
            // set the owning side to null (unless already changed)
            if ($orderItem->getOwnerOrder() === $this) {
                $orderItem->setOwnerOrder(null);
            }
        }

        return $this;
    }

    #[ORM\PrePersist]
    public function markOrderAsPlaced(): void
    {
        $this->setCreatedAt(new \DateTimeImmutable());
        $this->setStatus(OrderStatus::PENDING);
    }

    #[ORM\PreUpdate]
    public function markOrderAsUpdated(): void
    {
        $this->setUpdatedAt(new \DateTimeImmutable());
    }
}
