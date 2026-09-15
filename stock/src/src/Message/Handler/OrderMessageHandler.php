<?php

namespace App\Message\Handler;

use App\DTO\Order as OrderDTO;
use App\Message\OrderMessage;
use App\Order\OrderCheckoutHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

#[AsMessageHandler]
class OrderMessageHandler
{
    public function __construct(
        private DenormalizerInterface $serializer,
        private OrderCheckoutHandler $orderHandler,
    ) {}

    public function __invoke(OrderMessage $message)
    {
        $payload = $message->orderPayload;

        if (isset($payload['order_items']) === false) {
            return;
        }

        $this->processPayload($payload);
    }

    private function processPayload(array $payload): void
    {
        $identifiers = \array_column($payload['order_items'], 'product_id');

        $data =  $this->serializer->denormalize($payload, OrderDTO::class);

        $this->orderHandler->handle($data, $identifiers);
    }
}
