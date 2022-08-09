<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSchedule extends Model
{
    use HasFactory;
    protected $table = 'job_schedules';
    protected $fillable = ['job_name', 'recipient', 'subject', 'message', 'reply_to', 'from', 'sender_name'];
}
