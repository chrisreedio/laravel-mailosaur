<?php

namespace ChrisReedIO\Mailosaur\Commands;

use Illuminate\Console\Command;

class MailosaurCommand extends Command
{
    public $signature = 'laravel-mailosaur';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
