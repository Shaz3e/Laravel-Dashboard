<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetToken extends Model
{
    use HasFactory;

    protected $table = "password_reset_tokens";

    protected $fillable = [
        'email',
        'token',
    ];

    protected function getAccountStatusAttribute($value)
    {
        return ucwords($value);
    }
}
