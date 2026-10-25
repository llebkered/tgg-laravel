<?php

namespace App\Enums;

/**
 * How an order was paid, or is to be paid. Order::$payment_method is cast to
 * this enum; it's null for older orders whose method wasn't recorded.
 */
enum PaymentMethod: string
{
    case Card = 'card';
    case DirectDeposit = 'direct_deposit';

    /**
     * The name shown to staff.
     */
    public function label(): string
    {
        return match ($this) {
            self::Card => 'Card',
            self::DirectDeposit => 'Direct deposit',
        };
    }

    /**
     * How the payment is described to customers on receipts.
     */
    public function receiptLabel(): string
    {
        return match ($this) {
            self::Card => 'credit card',
            self::DirectDeposit => 'direct deposit',
        };
    }
}
