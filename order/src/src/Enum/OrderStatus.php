<?php

namespace App\Enum;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case SHIPPED = 'shipped';
    case FUNDED = 'funded';
    case CONFIRMED = 'confirmed';
}
