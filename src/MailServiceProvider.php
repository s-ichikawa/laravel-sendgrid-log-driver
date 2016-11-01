<?php
namespace Sichikawa\LaravelSendgridLogDriver;

class MailServiceProvider extends \Illuminate\Mail\MailServiceProvider
{
    public function register()
    {
        parent::register();

        $this->app->register(SendgridLogTransportServiceProvider::class);
    }
}
