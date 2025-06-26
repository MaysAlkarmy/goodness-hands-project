<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;

    protected $fillable= ['name', 'description', 'image', 'main_category', 'price'];

    
     public function category()
    {
        return $this->belongsTo(Category::class);
    }

     public function user()
{
    return $this->belongsTo(User::class);
}

}
