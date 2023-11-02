<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'alpha2',
        'alpha3',
        'flag',
        'currency',
        'currency_code',
        'calling_code',
    ];
}
