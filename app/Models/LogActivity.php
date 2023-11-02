<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'subject',
        'url',
        'method',
        'ip',
        'agent',
    ];

    /**
     * Get subject with PHP function
     */
    protected function getSubjectAttribute($value)
    {
        return ucfirst($value);
    }
}
