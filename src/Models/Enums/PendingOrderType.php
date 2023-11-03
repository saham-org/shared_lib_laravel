<?php

namespace Saham\SharedLibs\Models\Enums;

enum PendingOrderType: string
{
    case order = 'order';
    case feast  = 'feast';
    case reservation  = 'reservation';
    case topup  = 'topup';
}
