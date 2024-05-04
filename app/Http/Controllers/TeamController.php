<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Models\Team;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success(Team::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTeamRequest $request)
    {
        $request->validated();

        try {
            Team::create([
                'name' => $request->post('name'),
                'description' => $request->post('description'),
                'slug' => Str::slug($request->post('name') . '-' . Str::random(10)),
            ]);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }

        return $this->success(['message' => 'Team created successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        return $this->success($team);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $request->validated();

        try {
            $team->update($request->all());
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }
        return $this->success(['message' => 'Team updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $team->delete();
        return $this->success(['message' => 'Team deleted successfully.']);
    }

    /**
     * Add user to the team
     */
    public function addMember(Request $request, Team $team)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'role' => 'required|string|in:admin,member',
        ]);

        $user = User::find($request->post('user_id'));

        $team->users()->attach($user, ['role' => $request->post('role')]);

        return $this->success(['message' => 'User added to the team successfully.']);
    }

    /**
     * Delete the user from the team
     *
     */
    public function removeMember(Team $team, $id)
    {
        $user = User::find($id);

        $team->users()->detach($user);

        return $this->success(['message' => 'User deleted from the team successfully.']);
    }
}
