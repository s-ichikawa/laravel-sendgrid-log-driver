<?php
namespace Sichikawa\LaravelSendgridLogDriver;

use Illuminate\Mail\TransportManager;
use Illuminate\Support\ServiceProvider;
use Sichikawa\LaravelSendgridLogDriver\Transport\SendgridLogTransport;

class SendgridLogTransportServiceProvider extends ServiceProvider
{
    /**
     * Register the Swift Transport instance.
     *
     * @return void
     */
    public function register()
    {
        $this->app->afterResolving(TransportManager::class, function (TransportManager $manager) {
            $this->extendTransportManager($manager);
        });
    }

    public function extendTransportManager(TransportManager $manager)
    {
        $manager->extend('sendgrid-log', function () {
            $config = $this->app['config']->get('services.sendgrid', []);
            return new SendgridLogTransport($this->app->make('Psr\Log\LoggerInterface'), array_get($config, 'api_key'));
        });
    }
}
