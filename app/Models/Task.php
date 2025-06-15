<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // app/Models/Task.php
    protected $fillable = [
        'title',
        'description',
        'deadline',
        'completed',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
