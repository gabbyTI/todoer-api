<?php

namespace App\Http\Controllers\Task;

use App\Helpers\ApiResponder;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Repositories\Contracts\ITask;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    protected $tasks;

    public function __construct(ITask $tasks)
    {
        $this->tasks = $tasks;
    }


    public function index()
    {
        $tasks =  $this->tasks->getUserTasks();

        return ApiResponder::successResponse('Data Found', TaskResource::collection($tasks));
    }

    public function findById(Task $task)
    {
        // dd($task);
        // $task = $this->tasks->findById($task->id);
        return ApiResponder::successResponse("Data Found", new TaskResource($task));
    }

    public function getTasksForToday()
    {
        $tasks =  $this->tasks->getUserTasksForToday(auth()->id());

        return ApiResponder::successResponse('Data Found', TaskResource::collection($tasks));
    }

    public function getCompletedTasks()
    {
        $tasks =  $this->tasks->getUserCompletedTasks();

        return ApiResponder::successResponse('Data Found', TaskResource::collection($tasks));
    }


    public function store(Request $request)
    {
        $request->validate([
            'body' => ['required'],
            'task_start_date' => ['required'],
            'priority' => ['required', 'max:1']
        ]);

        $task = $this->tasks->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
            'priority' => $request->priority,
            'task_start_date' => $request->task_start_date,
            'task_end_date' => $request->task_end_date
        ]);

        $task = $this->tasks->find($task->id);

        return ApiResponder::successResponse("Task saved", new TaskResource($task));
    }



    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'body' => ['required'],
            'task_start_date' => ['required'],
            'priority' => ['required', 'max:1']
        ]);

        $task = $this->tasks->update($task->id, [
            'body' => $request->body,
            'priority' => $request->priority,
            'task_start_date' => $request->task_start_date,
            'task_end_date' => $request->task_end_date
        ]);

        return ApiResponder::successResponse("Task Updated", new TaskResource($task));
    }

    public function markTaskAsCompleted(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        if ($task->is_completed)
            $task = $this->tasks->update($task->id, [
                "is_completed" => false
            ]);
        else
            $task = $this->tasks->update($task->id, [
                "is_completed" => true
            ]);

        return ApiResponder::successResponse("Task Marked", new TaskResource($task));
    }


    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $this->tasks->delete($task->id);

        return ApiResponder::successResponse("Task Deleted");
    }
}
