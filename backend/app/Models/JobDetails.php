<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;

    class JobDetails extends Model
    {
        use HasFactory;

        protected $table = 'job_details';
        protected $fillable = [
            'job_id', 'messageId', 'recipient', 'webhook_id', 'webhook_server_timestamp', 'ts', 'ts_event', 'event',
            'date', 'sending_ip',
        ];

        public function jobList(): BelongsTo
        {
            return $this->belongsTo(JobLists::class, 'job_id');
        }
    }
