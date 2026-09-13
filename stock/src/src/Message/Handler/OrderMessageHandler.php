<?php

namespace App\Message\Handler;

use App\DTO\Order;
use App\Entity\Product;
use App\Message\OrderMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[AsMessageHandler]
class OrderMessageHandler
{
    public function __construct(private EntityManagerInterface $entityManager, private DenormalizerInterface $serializer) {}

    public function __invoke(OrderMessage $message)
    {
        $payload = $message->orderPayload;

        if (isset($payload['order_items']) === false) {
            return;
        }   

       $data =  $this->serializer->denormalize(
            $payload,
            Order::class
        );

        dd($data, $payload);

        $identifiers = \array_column($payload['order_items'], 'product_id');

        $repository = $this->entityManager->getRepository(Product::class);

        $products = $repository->getProducts($identifiers);

        foreach ($products as $product) {
            // Process each product as needed
        }

        dd($identifiers, $products);
    }
}
