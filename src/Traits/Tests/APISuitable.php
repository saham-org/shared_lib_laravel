<?php

namespace Saham\SharedLibs\Traits\Tests;

use Database\Seeders\DatabaseSeeder;
use Database\Seeders\OauthClientsSeeder;

trait APISuitable
{
    protected function tearDown(): void
    {
        // parent::tearDown();
        (new DatabaseSeeder())->call(OauthClientsSeeder::class);
    }
}
