<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $with = ['category', 'images'];
    protected $guarded = [];

    public function images(): HasMany {
        return $this->hasMany(Image::class);
    }

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }
}
