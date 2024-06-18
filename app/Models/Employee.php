<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';
    protected $fillable = [
        'first_name',
        'last_name',
        'image',
        'phone_number',
        'email',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
