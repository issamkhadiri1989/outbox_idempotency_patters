<?php

namespace App\DTO;

use Symfony\Component\Serializer\Attribute\SerializedName;

class OrderItem
{
    public function __construct(
        #[SerializedName("product_id")]
        public string $productIdentifier,
        public int $quantity,
        public float $price,
    ) {}
}
