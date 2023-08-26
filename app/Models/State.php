<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class State extends Model
{
    use HasFactory;

    protected $fillable = ['country_code','name'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function employee(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
