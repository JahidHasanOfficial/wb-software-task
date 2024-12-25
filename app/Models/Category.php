<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
    protected $table = 'categories';

    protected $primaryKey = 'id';   

    protected $fillable = [
        'name', 
        'slug',
         'image', 
         'parent_id'
        ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getImageAttribute($value){
        return $value ? url('storage/' . $value) : null;
    }
}
