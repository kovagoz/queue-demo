<?php

namespace App\Providers;

use App\Contracts\Mail\Transport;
use App\Mail\Transport\Sendmail;

class MailServiceProvider extends ServiceProvider
{
    /**
     * Register bindings.
     *
     * @return void
     */
    public function register()
    {
        $this->container->singleton(Transport::class, function () {
            return new Sendmail;
        });

        $this->container->alias(Transport::class, 'mail');
    }
}
