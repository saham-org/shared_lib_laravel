<?php

namespace Saham\SharedLibs\Traits\Tests;

use Artisan;
use Illuminate\Foundation\Testing\DatabaseMigrations;

trait MongoClearDatabase
{
    // use DatabaseMigrations;
    protected static $setUpHasRunOnce = false;

    protected function setUp(): void
    {
        parent::setUp();

        if (!static::$setUpHasRunOnce) {
            Artisan::call('migrate:fresh');
            Artisan::call('db:seed', [
                '--class' => 'SettingSeeder',
            ]);
            static::$setUpHasRunOnce = true;
        }
    }
}
