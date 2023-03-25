<?php

namespace SahamLibs\Models\Enums;

enum LocationType: string
{
    case Home    = 'Home';
    case Work    = 'Work';
    case Hangout = 'Hangout';
    case Camp    = 'Camp';
}
