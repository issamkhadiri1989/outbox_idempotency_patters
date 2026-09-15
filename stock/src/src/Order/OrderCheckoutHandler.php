<?php

namespace App\Order;

use App\DTO\Order;
use App\Entity\Product;
use App\Exception\InsuffisantQuantityRequestedException;
use Doctrine\ORM\EntityManagerInterface;

class OrderCheckoutHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function handle(Order $order, array $identifiers)
    {
        $repository = $this->entityManager->getRepository(Product::class);

        $products = $repository->getProducts($identifiers);

        $this->processQuantities($order, $products);

        $this->entityManager->flush();
    }

    private function processQuantities(Order $order, array $products): void
    {
        foreach ($order->orderItems as $orderItem) {
            $productIdentifier = $orderItem->productIdentifier;

            $product = $this->extractProduct($products, $productIdentifier);

            if (null === $product) {
                continue;
            }

            $requestedQuantity = $orderItem->quantity;
            $remainingQuantity = $product->getTotalQuantity() - $requestedQuantity;

            if ($remainingQuantity < 0) {
                throw new InsuffisantQuantityRequestedException();
            }

            $product->setTotalQuantity($remainingQuantity);
        }
    }

    /**
     * @param Product[] $products
     * 
     * @param string $productIdentifier
     * 
     * @return Product|null
     */
    private function extractProduct(array $products, string $productIdentifier): ?Product
    {
        foreach ($products as $product) {
            if ($product->identifierAsString === $productIdentifier) {
                return $product;
            }
        }

        return null;
    }
}
