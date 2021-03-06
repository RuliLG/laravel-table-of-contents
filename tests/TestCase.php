<?php

namespace RuliLG\TableOfContents\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use RuliLG\TableOfContents\TableOfContentsServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            TableOfContentsServiceProvider::class,
        ];
    }
}
