<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;

    class JobLists extends Model
    {
        use HasFactory;

        protected $table = 'job_lists';
        protected $fillable = [
            'job_name', 'subject', 'from', 'reply_to', 'sender_name', 'message',
        ];

        public function jobDetails()
        {
            return $this->hasMany(JobDetails::class);
        }
    }
