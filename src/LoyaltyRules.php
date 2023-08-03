<?php

namespace Up2date\FlowPhpSdk;

/**
 * This object represents the rules of the loyalty program.
 *
 *
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property float $loyaltyEarn Loyalty earn ratio
 * @property float $loyaltySpend Loyalty spend ratio
 * @property float $loyaltyMaximSpend Loyalty max spend percentage
 * @property float $loyaltyExpirationDays Loyalty expiration days
 * @property float $loyaltyMinimRequiredPoints Loyalty minim required to spend
 */
class LoyaltyRules
{
    const OBJECT_NAME = 'loyaltyRules';
}