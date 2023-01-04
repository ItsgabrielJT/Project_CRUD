<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoce extends Model
{
    use HasFactory;

    protected $fillable = ['serie', 'estatus', 'buyer_id'];

    public function buyer() {
        return $this->belongsTo(Buyer::class);
    }
}
