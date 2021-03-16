<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'body',
        'is_completed',
        'priority',
        'task_date',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
