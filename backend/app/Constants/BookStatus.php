<?php

namespace App\Constants;

abstract class BookStatus
{
    const AVAILABLE = 'Available';
    const BORROWED = 'Borrowed';
    
    public static function getStatus() : array {
        return [
            self::AVAILABLE,
            self::BORROWED
        ];
    } 
}
