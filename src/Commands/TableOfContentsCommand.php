<?php

namespace RuliLG\TableOfContents\Commands;

use Illuminate\Console\Command;

class TableOfContentsCommand extends Command
{
    public $signature = 'laravel-table-of-contents';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
