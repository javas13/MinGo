<?php

namespace App\Services;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Place;

class SitemapService
{
    public function generate(): void
    {
        $sitemap = Sitemap::create();
        
        // Добавляем статические страницы
        $sitemap->add(Url::create('/')
            ->setPriority(1.0)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
        
        // $sitemap->add(Url::create('/about')
        //     ->setPriority(0.8)
        //     ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        
        // Добавляем все заведения
        $places = Place::all();
        
        foreach ($places as $place) {
            $sitemap->add(Url::create("/places/{$place->slug}")
                ->setLastModificationDate($place->updated_at)
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        }
        
        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}