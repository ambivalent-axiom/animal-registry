<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Animal extends Model
{
    use HasFactory, softDeletes;
    protected $fillable = [
        'user_id',
        'farm_id',
        'animal_number',
        'type_name',
        'years'
    ];
    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }
}
