<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class JobLists extends Model
    {
        use HasFactory;

        protected $table = 'job_lists';
        protected $fillable = [
            'job_name', 'subject', 'from', 'reply_to', 'sender_name', 'message', 'draft_id'
        ];

        public function job_details()
        {
            return $this->hasMany(JobDetails::class);
        }

        public function drafts() {
            return $this->hasOne(Drafts::class);
        }
    }
