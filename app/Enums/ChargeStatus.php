<?php

namespace App\Enums;

/**
 * The outcome of trying to charge an order to a card.
 */
enum ChargeStatus
{
    // The card was charged and the order is paid.
    case Paid;

    // Pin rejected the charge (e.g. card declined). Nothing was charged, so the
    // customer can try again.
    case Declined;

    // Another request is already charging the order, or an earlier charge
    // could not be confirmed.
    case AlreadyClaimed;

    // Pin's reply was missing or unclear, so the card may have been charged.
    case Unconfirmed;
}
