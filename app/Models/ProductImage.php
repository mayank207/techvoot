<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $table="products_image";
    protected $fillable =['product_id', 'image_name'];

    public function getImageNameAttribute($id)
    {
        $imgname = $this->attributes['image_name'];
        return public_path()."/uploads / ". $this->product_id."/".$imgname;
    }
}
