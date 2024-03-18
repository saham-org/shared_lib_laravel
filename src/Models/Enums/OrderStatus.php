<?php

namespace Saham\SharedLibs\Models\Enums;

enum OrderStatus: string
{
    case Pending   = 'pending';
    case Accepted  = 'accepted';
    case Assigned  = 'assigned';

    case InDeliver = 'in_deliver';

    case Completed = 'completed';

    case Cancelled = 'cancelled';

    case Rejected = 'rejected';

    case Refresh = 'refresh';

    case Expired = 'expired';

    case Refunded = 'refunded';

    case Preparing = 'preparing';
    case Prepared = 'prepared';

    case InLocation = 'in_location';

    case Approved = 'approved';

    case InDelivery = 'in_delivery';

    case InProgress = 'in_progress';

    case Opened = 'opened';

    case Closed = 'closed';
    
    case PriceReview = 'price_review';

    case Paid = 'paid';

    /**
     *  Get all active statuses.
     *
     * @return array<string>
     */
    public static function onlyActive(): array
    {
        return array_column(([
            self::Pending,
            self::Assigned,
            self::Approved,
            self::InDelivery,
            self::InLocation,
            self::Refresh,
            self::Preparing,
            self::Prepared,
            self::Accepted,
            self::PriceReview ,
            self::Paid ,
        ]), 'value');
    }

    /**
     *  Get all active statuses.
     *
     * @return array<string>
     */
    public static function onlyInWay(): array
    {
        return array_column(([
            self::Pending,
            self::InDelivery,
            self::InLocation,
        ]), 'value');
    }

    /**
     *  Get all finished statuses.
     *
     * @return array<string>
     */
    public static function onlyFinished(): array
    {
        return array_column(([
            self::Completed,
            self::Refunded,
        ]), 'value');
    }

    /**
     *  Get all failed statuses.
     *
     * @return array<string>
     */
    public static function onlyFailed(): array
    {
        return array_column(([
            self::Refunded,
            self::Expired,
            self::Cancelled,
        ]), 'value');
    }

    /**
     *  Get all finished statuses.
     *
     * @return array<string>
     */
    public static function onlyComplete(): mixed
    {
        return array_column(([
            self::Completed,
            self::Refunded,
            self::Expired,
            self::Cancelled,
            self::Rejected,
        ]), 'value');
    }

    /**
     * Get all statues statuses.
     *
     * @return array<string>
     */
    public static function toArray(): array
    {
        return array_column(OrderStatus::cases(), 'value');
    }

    /**
     * Get all drivers statuses.
     *
     * @return array<string>
     */
    public static function onlyActiveForDrivers(): array
    {
        return array_column(([
            self::Pending,
            self::Preparing,
            self::Prepared,
            self::InDelivery,
            self::Rejected,
            self::Completed,
            self::Accepted,
            self::PriceReview ,
        ]), 'value');
    }

    /**
     * Get all drivers change to status statuses.
     *
     * @return array<string>
     */
    public static function onlyDriverCanChangeTo(): array
    {
        return array_column(([
            self::InLocation,
            self::Rejected,
            self::Completed,
            self::Accepted,
            self::InDelivery,
        ]), 'value');
    }
}