<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $fillable = ['products_name', 'categories_id', 'price', 'description', 'stok'];

    public function category()
    {
        return $this->belongsTo(categories::class);
    }
}
