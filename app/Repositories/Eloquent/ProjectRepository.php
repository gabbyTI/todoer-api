<?php

namespace App\Repositories\Eloquent;

use App\Models\Project;
use App\Repositories\Contracts\IProject;
use App\Repositories\Criteria\ICriteria;

class ProjectRepository  extends BaseRepository implements
    IProject
{
    public function model()
    {
        return Project::class;
    }

    public function fetchUserProjects()
    {
        // return auth()->user()->projects()->get();
        return auth()->user()->projects;
    }
}
