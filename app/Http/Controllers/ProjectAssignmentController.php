<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectAssignment;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ProjectAssignmentController extends Controller
{
    use HttpResponses;
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'user_id' => ['required', 'integer','exists:users,id'],
            'role' => ['required', 'string','in:manager,developer'],
        ]);

        try {
            $user = User::find($request->post('user_id'));
            $project->users()->attach($user, ['role' => $request->post('role')]);
        } catch (\Exception $exception) {
            return $this->error(['message' => $exception->getMessage()]);
        }


        return $this->success(['message' => 'User added to project successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, User $user)
    {
        try {
            $project->users()->detach($user);
        } catch (\Exception $exception) {
            return $this->error(['message' => $exception->getMessage()]);
        }

        return $this->success(['message' => 'Project assignment deleted successfully.']);
    }
}
