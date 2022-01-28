<?php

namespace RuliLG\TableOfContents\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RuliLG\TableOfContents\TableOfContents
 */
class TableOfContents extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-table-of-contents';
    }
}
