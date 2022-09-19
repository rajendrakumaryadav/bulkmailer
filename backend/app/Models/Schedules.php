<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasOne;

    class Schedules extends Model
    {
        use HasFactory;

        protected $table = 'schedules';
        protected $fillable = [
            'name', 'schedule_date', 'schedule_time', 'is_active',
        ];

        public function scopeActive($query)
        {
            return $query->where('is_active', true);
        }

        public function scopeInactive($query)
        {
            return $query->where('is_active', false);
        }

        public function scopeToday($query)
        {
            return $query->where('schedule_date', date('Y-m-d'));
        }

        public function scopeTomorrow($query)
        {
            return $query->where('schedule_date', date('Y-m-d', strtotime('+1 day')));
        }

        // adding relation of Schedule to Draft
        public function draft(): BelongsTo
        {
            return $this->belongsTo(Drafts::class);
        }

    }
