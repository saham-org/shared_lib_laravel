<?php

namespace Saham\SharedLibs\Models\Enums;

enum DeliveryFee: int
{
    case Free       = 0;
    case Fixed_9    = 9;
    case Fixed_7    = 7;
    case Calculated = 100;
}
