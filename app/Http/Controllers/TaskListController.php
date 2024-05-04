<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskListRequest;
use App\Http\Requests\UpdateTaskListRequest;
use App\Models\TaskList;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class TaskListController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success([
            'task_lists' => TaskList::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskListRequest $request)
    {
        $request->validated();

        try {
            TaskList::create($request->all());
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }

        return $this->success([
            'message' => 'Task list created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskList $taskList)
    {
        return $this->success([
            'task_list' => $taskList
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskListRequest $request, TaskList $taskList)
    {
        $request->validated();

        try {
            $taskList->update($request->all());
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }

        return $this->success([
            'message' => 'Task list updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskList $taskList)
    {
        $taskList->delete();

        return $this->success([
            'message' => 'Task list deleted successfully'
        ]);
    }
}
