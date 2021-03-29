<?php

namespace App\Repositories\Contracts;

interface IInvitation
{
    public function addUserToProject($project, $user_id);
}
