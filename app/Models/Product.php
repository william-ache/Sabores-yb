<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'image_path',
        'category_id',
        'is_active',
        'sort_order'
    ];

    public function category_rel()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
