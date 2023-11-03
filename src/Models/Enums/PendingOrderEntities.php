<?php

namespace Saham\SharedLibs\Models\Enums;

enum PendingOrderEntities: string
{
    case driver         = 'driver';
    case user           = 'user';
    case manager        = 'manager';
    case parnter        = 'parnter';
}
