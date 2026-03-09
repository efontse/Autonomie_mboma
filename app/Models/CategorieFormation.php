<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategorieFormation extends Model
{
    protected $table = 'categories_formation';

    protected $fillable = ['nom', 'description', 'icone', 'couleur'];

    public function formations(): HasMany
    {
        return $this->hasMany(Formation::class, 'categorie_id');
    }
}

