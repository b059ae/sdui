<?php

namespace App\Console\Commands;

use App\Models\News;
use Illuminate\Console\Command;

class DeleteNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:delete {--days=14}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all news older than X days';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        News::olderThanXDays($this->option('days'))->delete();
        return 0;
    }
}
