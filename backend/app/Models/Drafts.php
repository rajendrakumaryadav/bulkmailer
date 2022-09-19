<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasOne;

    class Drafts extends Model
    {
        use HasFactory;

        protected $table = "drafts";
        protected $fillable = ['*'];

        public function job_lists(): BelongsTo
        {
            return $this->belongsTo(JobLists::class);
        }

        public function schedules(): HasOne
        {
            return $this->hasOne(Schedules::class);
        }
    }
