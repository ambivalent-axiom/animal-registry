<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Animal extends Model
{
    use HasFactory;
    protected $fillable = [
        'animal_number',
        'type_name',
        'years'
    ];
    public function farm(): BelongsTo
    {
        return $this->belongsTo(Farm::class);
    }
}
