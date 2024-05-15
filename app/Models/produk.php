<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class produk extends Model
{
    use HasFactory;

    protected $fillable=['nama','stock','harga','description'];

  
    public function detil_transaksi():HasMany
    {
        return $this->hasMany(detil_transaksi::class);
    }
}
