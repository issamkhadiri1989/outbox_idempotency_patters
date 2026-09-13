<?php

namespace App\Message;

use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage(transport: 'async')]
class OrderMessage
{
    public function __construct(
        public string $eventName,
        public array $orderPayload,
    ) {}
}
