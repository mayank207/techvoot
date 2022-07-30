<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $table="brands";
    protected $fillable =['name'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
