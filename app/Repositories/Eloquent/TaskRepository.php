<?php

namespace App\Repositories\Eloquent;

use App\Models\Task;
use App\Repositories\Contracts\ITask;
use Carbon\Carbon;

class TaskRepository extends BaseRepository implements ITask
{
    public function model()
    {
        return Task::class;
    }

    public function getUserTasks()
    {
        return auth()->user()->tasks;
    }

    public function getUserTasksForToday()
    {
        return auth()->user()->tasks->where('task_start_date', Carbon::today()->toDateString());
    }

    public function getUserCompletedTasks()
    {
        return auth()->user()->tasks->where('is_completed', true);
    }
}
