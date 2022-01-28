<?php

namespace RuliLG\TableOfContents;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use RuliLG\TableOfContents\Commands\TableOfContentsCommand;

class TableOfContentsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-table-of-contents')
            ->hasConfigFile()
            ->hasViews();
    }
}
