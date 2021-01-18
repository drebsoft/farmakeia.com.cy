<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Str;

class Pharmacy extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasSlug;

    protected $guarded = ['id'];

    protected $casts = [
        'is_admin' => 'boolean'
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

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }
}
