<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unite extends Model
{
    protected $fillable = [
        'libelle'
    ];

    public function uniteCategories()
    {
        return $this->hasMany(UniteCategorie::class);
    }
}
