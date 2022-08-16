<?php

namespace App\Console\Commands;

use App\Services\ImportPostsService;
use Illuminate\Console\Command;

class ImportPostsCommand extends Command
{
    protected $signature = 'import:posts';
    protected $description = 'This command execute import from external platform';

    public function __construct(
        protected ImportPostsService $service
    ) {
        parent::__construct();
    }

    public function handle()
    {
        if ($this->confirm('Import posts?', true)) {
            $this->service->handle();
            $this->info('Posts imported!');
        }else{
            $this->warn('Posts import cancelled!');
        }
    }
}
