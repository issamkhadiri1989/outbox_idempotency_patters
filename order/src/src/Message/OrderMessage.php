<?php

namespace App\Message;

use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage(transport: 'async')]
final class OrderMessage
{
    public function __construct(
        public string $eventName,
        public array $orderPayload,
    ) {}
}
