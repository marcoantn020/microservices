<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'url', 'description'];

    public function companies(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Company::class);
    }
}
