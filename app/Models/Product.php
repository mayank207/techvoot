<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table="products";
    protected $fillable =['name', 'image', 'price', 'brand_id'];

    public function brand(){
        return $this->belongsTo(Brand::class,'id','brand_id');
    }
}
