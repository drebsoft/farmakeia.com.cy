<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Str;

class Pharmacy extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'is_admin' => 'boolean'
    ];

    public function path()
    {
        return route('pharmacies.show', ['pharmacy' => $this->id]);
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
        return $this->availabilities()->orderBy('date')->where('date', '>=', now())->get();
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

    public function getMapAddressAttribute()
    {
        $address = $this->address ?? '';
        $address = Str::of($address)->slug(' ');
        $area = $this->area ?? '';
        $area = Str::of($area)->slug(' ');
        $region = $this->region ?? '';
        $region = Str::of($region)->slug(' ');
        if ($area != '') {
            $address = $address . ', ' . $area;
        }
        if ($region != '') {
            $address = $address . ', ' . $region;
        }
        return Str::of($address)->replace(' ', '+');
    }
}
