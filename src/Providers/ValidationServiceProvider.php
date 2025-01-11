<?php

namespace Saham\SharedLibs\Providers;

use Illuminate\Validation\ValidationServiceProvider as BaseProvider;
use MongoDB\Laravel\Validation\DatabasePresenceVerifier;
use MongoDB\Laravel\Validation\ValidationServiceProvider as ValidationValidationServiceProvider;

class ValidationServiceProvider extends ValidationValidationServiceProvider
{
}
