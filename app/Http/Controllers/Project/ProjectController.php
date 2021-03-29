<?php

namespace App\Http\Controllers\Project;

use App\Helpers\ApiResponder;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\User;
use App\Repositories\Contracts\IProject;
use App\Repositories\Contracts\IUser;
use App\Repositories\Eloquent\Criteria\EagerLoad;
use App\Repositories\Eloquent\Criteria\ForUser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    protected $projects;

    public function __construct(IProject $projects)
    {
        $this->projects = $projects;
    }

    /**
     * Get projects the current user belongs to
     */
    public function fetchUserProjects(Request $request)
    {
        $projects = $this->projects->withCriteria([
            new ForUser(auth()->id()),
            new EagerLoad(['owner', 'tasks', 'members'])
        ])->all();
        return ApiResponder::successResponse("Data found", ProjectResource::collection($projects));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:80', 'unique:projects,name'],
        ]);

        $project = $this->projects->create(
            [
                'owner_id' => auth()->id(),
                'name' => $request->name,
                'slug' => Str::slug($request->name)
            ]
        );

        $project = $this->projects->find($project->id);

        // current user is inserted as project member using the boot methodin project model
        return ApiResponder::successResponse("Project created", new ProjectResource($project));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $request->validate([
            'name' => ['required', 'string', 'max:80', 'unique:projects,name,' . $project->id],
        ]);

        $project = $this->projects->update($project->id, [
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        $project = $this->projects->find($project->id);

        return ApiResponder::successResponse("Project updated", new ProjectResource($project));
    }

    public function findById(Request $request, Project $project)
    {
        return ApiResponder::successResponse("Data found", new ProjectResource($project));
    }

    // public function findBySlug(Request $request)
    // {
    // }

    public function destroy(Request $request, Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete($project->id);

        return ApiResponder::successResponse("Project Deleted");
    }

    public function removeFromProject(Project $project, User $user)
    {
        // you cannot remove a user from a project you dont own
        if (!auth()->user()->isOwnerOfProject($project) && auth()->id() != $user->id) {
            return ApiResponder::failureResponse("You cannot do this", 401);
        }

        if ($user->isOwnerOfProject($project)) {
            return ApiResponder::failureResponse("This is the project owner", 401);
        }

        if (!$project->hasUser($user)) {
            return ApiResponder::failureResponse("This user is not a member of this project", 422);
        }

        $this->projects->removeUserFromProject($project, $user->id);

        return ApiResponder::successResponse("User removed");
    }
}
