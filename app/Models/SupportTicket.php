<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'ticket_number',
        'user_id',
        'ticket_status_id',
        'support_ticket_priority_id',
        'title',
        'message',
        'is_locked',
    ];
}
