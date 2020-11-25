<?php namespace App\Actions\Importer\Crawler;

use Spatie\Browsershot\Browsershot;

class Crawler
{
    public static function get($url)
    {
        return Browsershot::url($url)->bodyHtml();
    }
}
