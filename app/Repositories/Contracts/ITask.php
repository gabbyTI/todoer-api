<?php

namespace App\Repositories\Contracts;

interface ITask
{
    public function getUserTasks();
    public function getUserTasksForToday();
    public function getUserCompletedTasks();
}
