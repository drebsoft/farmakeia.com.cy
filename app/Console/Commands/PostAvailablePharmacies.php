<?php

namespace App\Console\Commands;

use App\Models\Pharmacy;
use App\Services\Facebook;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PostAvailablePharmacies extends Command
{
    protected $signature = 'pharmacies:post-available {region=all} {--dry-run}';

    protected $description = 'Post available pharmacies for the day to Facebook';

    public function handle()
    {
        $region = $this->argument('region');
        $dryrun = $this->option('dry-run') ?? false;

        $query = Pharmacy::query();

        if ($region !== 'all') {
            $query->where('region', Str::ucfirst(Str::lower($region)));
        }

        $query->whereHas('availabilities', function (Builder $query) {
            $query->where('date', now()->format('Y-m-d'));
        });

        $result = $query->get();
        if ($result === null || $result->count() === 0) {
            $this->info('Unable to find any available pharmacies to post.');
            return 0;
        }

        $this->info('Found a total of ' . $result->count() . ' available pharmacies.');

        setlocale(LC_TIME, config('facebook.locale'));
        $postContent = 'Εφημερεύοντα φαρμακεία - ' . now()->format('d/m/Y') . PHP_EOL . PHP_EOL;
        $postContent .= 'Δείτε όλα τα φαρμακεία που εφημερεύουν σήμερα, ' . now()->formatLocalized('%A %d %B %Y') . '. Πατήστε τον παρακάτω σύνδεσμο για να τα δείτε σε χάρτη, ή διαλέξτε κάποιο από τα παρακάτω φαρμακεία ανά επαρχία για να δείτε την ακριβή διεύθυνση και το τηλέφωνό του.' . PHP_EOL;
        $postContent .= url('/map') . PHP_EOL . PHP_EOL;
        $pharmaciesByRegion = $result->groupBy('region');

        foreach ($pharmaciesByRegion as $currentRegion => $pharmacies) {
            $this->info($pharmacies->count() . ' for ' . $currentRegion);
            $postContent .= '------' . PHP_EOL . PHP_EOL;
            $postContent .= 'Φαρμακεία ' . __($currentRegion . '_with_article') . PHP_EOL;
            $postContent .= route('farmakeia', ['region' => $pharmacies->first()->getSeoRegionAlias()]) . PHP_EOL . PHP_EOL;
            foreach ($pharmacies as $pharmacy) {
                $postContent .= $pharmacy->name . ', ' . $pharmacy->area . PHP_EOL;
                $postContent .= $pharmacy->seo_url . PHP_EOL;
            }
            $postContent .= PHP_EOL;
        }

        if ($dryrun) {
            $this->info('Final result follows:');
            $this->info($postContent);
            return 0;
        }

        $fb = new Facebook;
        $outcome = $fb->postToPage($postContent);

        $failed = $outcome['status'] === 'error';
        $this->{$failed ? 'error' : 'info'}($outcome['message']);

        return $failed ? 1 : 0;
    }
}
