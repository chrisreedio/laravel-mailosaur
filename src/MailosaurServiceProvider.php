<?php

namespace ChrisReedIO\Mailosaur;

use ChrisReedIO\Mailosaur\Commands\MailosaurCommand;
use Mailosaur\MailosaurClient;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MailosaurServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-mailosaur')
            ->hasConfigFile();
        // ->hasViews()
        // ->hasMigration('create_laravel_mailosaur_table')
        // ->hasCommand(MailosaurCommand::class);
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(Mailosaur::class, function ($app) {
            $config = $app['config']->get('mailosaur');

            $apiKey = $config['api_key'] ?? null;
            if (! is_string($apiKey) || $apiKey === '') {
                throw new \RuntimeException('MAILOSAUR_API_KEY is not set in configuration.');
            }

            $client = new MailosaurClient($apiKey);

            return new Mailosaur(
                client: $client,
                serverId: $config['server_id'] ?? null,
                domain: $config['domain'] ?? null,
            );
        });
    }
}
