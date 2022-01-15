<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Pharmacy extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;

    protected $guarded = ['id'];

    protected $casts = [
        'is_admin' => 'boolean',
        'does_rapid_tests' => 'boolean',
    ];

    protected $appends = ['seo_url'];

    public function adminPath()
    {
        return route('admin.pharmacies.show', ['pharmacy' => $this->id]);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function availabilities(): HasMany
    {
        return $this->hasMany(Availability::class);
    }

    public function futureAvailabilities(): Collection
    {
        return $this->availabilities()->orderBy('date')->where('date', '>=', now()->format('Y-m-d'))->get();
    }

    public function getSeoRegionAlias()
    {
        switch ($this->region) {
            case 'Nicosia':
                return 'lefkosia';
            case 'Limassol':
                return 'lemesos';
            case 'Paphos':
                return 'paphos';
            case 'Paralimni':
                return 'paralimni';
            case 'Larnaca':
                return 'larnaka';
        }
    }

    public function getIsAvailableAttribute()
    {
        return $this->availabilities()->where('date', now()->format('Y-m-d'))->exists();
    }

    public function getSeoUrlAttribute()
    {
        return route('farmakeio', ['am' => $this->am, 'slug' => $this->slug]);
    }

    public function getAvatarUrlAttribute()
    {
        $name = preg_replace("/[^a-zA-Z\p{Greek} ]+/u", "", $this->name);
        $name = collect(explode(' ', $name))->filter()->values()->map(function ($part) {
            return Str::substr($part, 0, 1);
        })->take(2)->implode('');

        return "https://ui-avatars.com/api/?name={$name}&color=7F9CF5&background=EBF4FF";
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
