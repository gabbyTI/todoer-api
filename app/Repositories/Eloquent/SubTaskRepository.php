<?php

namespace App\Repositories\Eloquent;

use App\Models\SubTask;
use App\Repositories\Contracts\ISubTask;


class SubTaskRepository extends BaseRepository implements ISubTask
{
    public function model()
    {
        return SubTask::class;
    }
}
