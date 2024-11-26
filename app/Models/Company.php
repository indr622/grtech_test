<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory;

    public mixed $employees;
    protected $fillable = [
        'name',
        'email',
        'logo',
        'website',
    ];



    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
