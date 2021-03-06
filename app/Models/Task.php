<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'body',
        'is_completed',
        'priority',
        'task_start_date',
        'task_end_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subTasks()
    {
        return $this->hasMany(SubTask::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getTodaysTasks()
    {
        return $this->where('task_start_date', Carbon::today()->toDateString());
    }
}
