<?php

namespace ChrisReedIO\Mailosaur;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use ChrisReedIO\Mailosaur\Commands\MailosaurCommand;

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
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_mailosaur_table')
            ->hasCommand(MailosaurCommand::class);
    }
}
