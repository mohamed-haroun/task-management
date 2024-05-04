<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Comment;
use App\Models\Task;
use App\Models\TaskList;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TaskController extends Controller
{

    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success([
            'tasks' => Task::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $request->validated();

        try {
            // Getting The task list
            $taskList = TaskList::find($request->post('task_list_id'));

            // Creating the task with assigning it to the task list
            $taskList->tasks()->create([
                'name' => $request->post('name'),
                'description' => $request->post('description'),
                'slug' => Str::slug($request->post('name') . '-' . Str::random(10)),
                'due_date' => $request->post('due_date'),
                'priority' => $request->post('priority'),
                'created_by' => Auth::id(),
                'assigned_to' => $request->post('assigned_to'),
            ]);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->success([
            'message' => 'Task created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return $this->success([
            'tasks' => $task
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $request->validated();

        try {
            $task->update($request->all());
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
        return $this->success([
            'message' => 'Task updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return $this->success([
            'message' => 'Task deleted successfully'
        ]);
    }
}
