<?php

namespace App\State\Processor;

use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\Order;
use App\Message\OrderMessage;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;

class OrderPrecessor implements ProcessorInterface
{
    public function __construct(
        #[Autowire(service: 'api_platform.doctrine.orm.state.persist_processor')]
        private ProcessorInterface $persistProcessor,
        private MessageBusInterface $messageBus,
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        /** @var Order $data */
        $data = $this->persistProcessor->process($data, $operation, $uriVariables, $context);

        $this->sendOrderMessage($data);

        return $data;
    }
    
    private function sendOrderMessage(Order $order): void
    {
        $payload = [
            'order_id' => $order->getId(),
            'order_status' => $order->getStatus(),
            'created_at' => $order->getCreatedAt(),
            'order_items' => [],
        ];

        foreach ($order->getOrderItems() as $orderItem) {
            $payload['order_items'][] = [
                'product_id' => $orderItem->getProduct()->getId(),
                'quantity' => $orderItem->getRequestedQuantity(),
                'price' => $orderItem->getUnitPrice(),
            ];
        }

        $message = new OrderMessage(
            eventName: 'orderPlaced',
            orderPayload: $payload
        );

        $this->messageBus->dispatch($message, [
            new AmqpStamp(routingKey: 'order.created')
        ]);  
    }
}
