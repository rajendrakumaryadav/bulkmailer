<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;

    class Drafts extends Model
    {
        use HasFactory;

        protected $table = "drafts";
        protected $fillable = ['*'];
        protected $hidden = ['id', 'created_at', 'updated_at'];

        public function job_lists(): BelongsTo
        {
            return $this->belongsTo(JobLists::class);
        }
    }
