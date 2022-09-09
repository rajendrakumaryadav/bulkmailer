<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Drafts extends Model
    {
        use HasFactory;

        protected $table = "drafts";
        protected $fillable = ['*'];
//        protected $guarded = ['created_at'];
    }
