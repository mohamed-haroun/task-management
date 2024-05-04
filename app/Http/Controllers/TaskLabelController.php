<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskLabel;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class TaskLabelController extends Controller
{
    use HttpResponses;
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $task->labels()->create($request->all());

        return $this->success([
            'message' => 'Label created successfully'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task, TaskLabel $label)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:255',
        ]);

        $task->labels()->update($request->all());

        return $this->success([
            'message' => 'Label updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task, $label)
    {
        $task->labels()->where('id', $label)->delete();
        return $this->success([
            'message' => 'Label deleted successfully'
        ]);
    }
}
