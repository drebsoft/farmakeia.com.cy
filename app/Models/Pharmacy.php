<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function path()
    {
        return "/pharmacies/{$this->id}";
    }
}
