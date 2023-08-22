<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniteCategorie extends Model
{
    protected $fillable = [
        'categorie_id', 'unite_id', 'conversion'
    ];

    public function unite()
{
    return $this->belongsTo(Unite::class, 'unite_id');
}

}
