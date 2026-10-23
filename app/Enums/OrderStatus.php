<?php

namespace App\Enums;

/**
 * Order status ids. These match the rows of the order_statuses table, which
 * holds the titles shown in the admin.
 */
enum OrderStatus: int
{
    case InCart = 1;
    case Invoiced = 2;
    case Paid = 3;
    case Shipped = 4;
    case OnHold = 5;
    case Cancelled = 6;
    case Refunded = 7;

    /**
     * Statuses of orders that still need work.
     */
    public static function open(): array
    {
        return [self::InCart->value, self::Invoiced->value, self::Paid->value];
    }
}
