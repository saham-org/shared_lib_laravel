<?php

namespace Saham\SharedLibs\Mongodb\Auth;

use Illuminate\Auth\Passwords\PasswordBrokerManager as BasePasswordBrokerManager;

class PasswordBrokerManager extends BasePasswordBrokerManager
{
    /**
     * @inheritdoc
     */
    protected function createTokenRepository(array $config)
    {
        $configApp = (array) $this->app['config'];
        return new DatabaseTokenRepository(
            $this->app['db']->connection(),
            $this->app['hash'],
            $config['table'],
            $configApp['app.key'],
            $config['expire']
        );
    }
}
