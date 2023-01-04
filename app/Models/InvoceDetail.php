<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoceDetail extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'invoce_id', 'cantidad', 'precio', 'product_total'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function invoce() {
        return $this->belongsTo(Invoce::class);
    }
}
