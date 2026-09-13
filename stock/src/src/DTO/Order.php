<?php

namespace App\DTO;

use App\Enum\OrderStatus;
use Symfony\Component\Serializer\Attribute\SerializedName;

class Order
{
    public function __construct(
        #[SerializedName('order_id')]
        public string $orderId,
        #[SerializedName('order_status')]
        public string $orderStatus,
        #[SerializedName('created_at')]
        public \DateTime $createdAt,
        #[SerializedName('order_items')]
        /**
         * @var OrderItem[] 
         */
        public array $orderItems,
    ) {}
}
