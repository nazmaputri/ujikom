<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'user_id', 
        'course_id', 
        'transaction_id', 
        'status'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'transaction_id', 'transaction_id');
    }
}
