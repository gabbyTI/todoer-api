<?php

namespace App\Http\Controllers\Task;

use App\Helpers\ApiResponder;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubTaskResource;
use App\Models\SubTask;
use App\Models\Task;
use App\Repositories\Contracts\ISubTask;
use Illuminate\Http\Request;

class SubTaskController extends Controller
{
    protected $subTasks;

    public function __construct(ISubTask $subTasks)
    {
        $this->subTasks = $subTasks;
    }

    public function store(Request $request, Task $task)
    {
        $request->validate([
            'body' => ['required'],
        ]);

        $subTask = $this->subTasks->create([
            'task_id' => $task->id,
            'body' => $request->body,
            'priority' => $request->priority == null ? 1 : $request->priority,
            'task_date' => $request->task_date,
        ]);

        $subTask = $this->subTasks->find($subTask->id);

        return ApiResponder::successResponse("Sub-task saved", new SubTaskResource($subTask));
    }



    public function update(Request $request, SubTask $subTask)
    {
        $this->authorize('update', $subTask);

        $request->validate([
            'body' => ['required'],
        ]);

        $subTask = $this->subTasks->update($subTask->id, [
            'body' => $request->body,
            'priority' => $request->priority,
            'task_date' => $request->task_date,
        ]);

        $subTask = $this->subTasks->find($subTask->id);

        return ApiResponder::successResponse("Sub-task Updated", new SubTaskResource($subTask));
    }

    public function findById(SubTask $subTask)
    {
        return ApiResponder::successResponse("Data Found", new SubTaskResource($subTask));
    }

    public function markSubTaskAsCompleted(Request $request, SubTask $subTask)
    {
        $this->authorize('update', $subTask);

        if ($subTask->is_completed)
            $subTask = $this->subTasks->update($subTask->id, [
                "is_completed" => false
            ]);
        else
            $subTask = $this->subTasks->update($subTask->id, [
                "is_completed" => true
            ]);

        $subTask = $this->subTasks->find($subTask->id);
        return ApiResponder::successResponse("Sub-task Marked", new SubTaskResource($subTask));
    }


    public function destroy(SubTask $subTask)
    {
        $this->authorize('delete', $subTask);
        $this->subTasks->delete($subTask->id);

        return ApiResponder::successResponse("Sub-task Deleted");
    }
}
