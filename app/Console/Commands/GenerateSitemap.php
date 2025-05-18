<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SitemapService;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate the sitemap.';

    public function handle()
    {
        app(SitemapService::class)->generate();
        $this->info('Sitemap generated successfully!');
    }
}
