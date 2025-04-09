<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifikasiMentorDaftar extends Model
{
    use HasFactory;

    protected $table = 'notifikasi_mentor_daftar';

    protected $fillable = [
        'user_id',
        'course_id',
        'message',
        'is_read',
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Course
     */
    public function course()
    {
        return $this->belongsTo(Course::class)->withDefault(); // dengan withDefault() supaya gak error walau null
    }

}
