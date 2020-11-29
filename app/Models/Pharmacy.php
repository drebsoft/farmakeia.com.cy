<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pharmacy extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
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

    public function availabilities() : HasMany
    {
        return $this->hasMany(Availability::class);
    }

    public function getMapAddressAttribute()
    {
        $address = $this->address ?? '';
        $area = $this->area ?? '';
        $region = $this->region ?? '';
        if ($area != '') {
            $address = $address . ', ' . $area;
        }
        if ($region != '') {
            $address = $address . ', ' . $region;
        }
        return $address;
    }
}
