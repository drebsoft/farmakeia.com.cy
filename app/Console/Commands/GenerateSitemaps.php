<?php

namespace App\Console\Commands;

use App\Models\Pharmacy;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemaps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates new sitemaps';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sitemap = Sitemap::create();
        $sitemap->add(
            Url::create('/')->setPriority(1.0)
        );

        foreach (Pharmacy::cursor() as $pharmacy) {
            /** @var Pharmacy $pharmacy */
            $sitemap->add(
                Url::create($pharmacy->seo_url)
                    ->setLastModificationDate($pharmacy->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(1.0)
            );
        }

        $sitemap->add(Url::create(route('how-it-works'))->setPriority(0.6));
        $sitemap->add(Url::create(route('privacy-policy'))->setPriority(0.5));

        $sitemap->writeToFile(public_path('sitemap.xml'));

        return 1;
    }
}
