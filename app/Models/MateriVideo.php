<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriVideo extends Model
{
    use HasFactory;

    protected $table = 'materi_video'; 

    protected $fillable = [
        'judul',
        'materi_id',
        'course_id',
        'video_url'
    ];

    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
