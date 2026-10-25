<?php

namespace App\Enums;

/**
 * Order status ids. Order::$order_status_id is cast to this enum. The ids
 * match the rows of the order_statuses table.
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
     * The name shown to staff. Matches the order_statuses table titles.
     */
    public function label(): string
    {
        return match ($this) {
            self::InCart => 'In Cart',
            self::Invoiced => 'Invoiced',
            self::Paid => 'Paid',
            self::Shipped => 'Shipped',
            self::OnHold => 'On Hold',
            self::Cancelled => 'Cancelled',
            self::Refunded => 'Refunded',
        };
    }

    /**
     * Statuses of orders that still need work.
     */
    public static function open(): array
    {
        return [self::InCart->value, self::Invoiced->value, self::Paid->value];
    }

    /**
     * Statuses of orders that have been paid for or closed off, so an
     * unfinished card payment no longer needs checking.
     */
    public static function settled(): array
    {
        return [self::Paid->value, self::Shipped->value, self::Cancelled->value, self::Refunded->value];
    }
}
