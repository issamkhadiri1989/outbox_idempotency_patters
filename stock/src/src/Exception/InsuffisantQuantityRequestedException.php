<?php

namespace App\Exception;

use Throwable;
use Override;

class InsuffisantQuantityRequestedException extends \Exception
{
    #[Override]
    public function __construct(string $message = "", int $code = 0, Throwable|null $previous = null)
    {
        $message = $message ?: 'Insufficient quantity requested.';
        
        return parent::__construct($message, $code, $previous);
    }
}
