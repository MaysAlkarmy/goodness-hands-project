<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable= ['card_number', 'owner_name', 'CVV', 'expiery_date'];
    

    public function user()
{
    return $this->belongsTo(User::class);
}

}
