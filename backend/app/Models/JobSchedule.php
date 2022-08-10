<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class JobSchedule extends Model
    {
        use HasFactory;

        protected $table = 'job_schedules';
        protected $fillable = [
            'job_name', 'messageId', 'recipient', 'subject', 'message', 'reply_to', 'from', 'sender_name',
            'webhook_id', 'webhook_server_timestamp', 'ts', 'ts_event', 'event', 'date', 'sending_ip'
        ];
    }
