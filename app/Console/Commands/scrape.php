<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class scrape extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scrape';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrapes posts from Hacker News.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Scraping has started. Please be patient.');
    }
}
