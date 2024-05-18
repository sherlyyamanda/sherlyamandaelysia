<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\HasMany;

class Pelanggan extends Model
{
    use HasFactory;
    protected $fillable=['nama','hp','address'];

    public function order():HasMany
    {
        return $this->hasMany(Order::class);
    }
}
