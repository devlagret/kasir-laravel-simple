<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use HasFactory,SoftDeletes;
    protected $table        = 'produk';
    protected $primaryKey   = 'ProdukID';
    protected $guarded = [
        'updated_at',
        'created_at'
    ];
}
