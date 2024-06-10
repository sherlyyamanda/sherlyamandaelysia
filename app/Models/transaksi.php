<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class transaksi extends Model
{
    use HasFactory;

    protected $fillable=['invoice','pelanggan_id','user_id','total'];

    public function detiltransaksi():HasMany
    {
        return $this->hasMany(detiltransaksi::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(user::class);
    }

    public function pelanggan():BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }
}


