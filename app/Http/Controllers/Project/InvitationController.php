<?php

namespace App\Http\Controllers\Project;

use App\Helpers\ApiResponder;
use App\Http\Controllers\Controller;
use App\Mail\sendInvitationToJoinProject;
use App\Models\Invitation;
use App\Models\Project;
use App\Repositories\Contracts\IInvitation;
use App\Repositories\Contracts\IProject;
use App\Repositories\Contracts\IUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    protected $invitations;
    protected $projects;
    protected $users;

    public function __construct(IInvitation $invitations, IProject $projects, IUser $users)
    {
        $this->invitations = $invitations;
        $this->projects = $projects;
        $this->users = $users;
    }

    public function invite(Request $request, Project $project)
    {
        // $project = $this->projects->find();

        $this->validate($request, [
            'email' => ['required', 'email']
        ]);

        $user = auth()->user();
        //check if user is owner of project
        if (!$user->isOwnerOfProject($project)) {
            return ApiResponder::failureResponse("You are not the project owner", 401);
        }
        //check if invite has already been sent to email
        if ($project->hasPendingInvite($request->email)) {
            return ApiResponder::failureResponse("User already has a pending invite", 422);
        }


        $recipient = $this->users->findByEmail($request->email);
        // check if recipient is not a regitered member and if not send a registration invitation
        if (!$recipient) {
            $this->createInvitation(false, $project, $request->email);
            return ApiResponder::successResponse("Invitation sent successfully");
        }

        //check if recipient is already a project member
        if ($project->hasUser($recipient)) {
            return ApiResponder::failureResponse("This user is already a project member", 422);
        }

        //send the project invitation
        $this->createInvitation(true, $project, $request->email);

        return ApiResponder::successResponse("Invitation sent successfully");
    }


    public function resend(Invitation $invitation)
    {
        # code...
        $this->authorize('resend', $invitation);

        $recipient = $this->users->findByEmail($invitation->recipient_email);

        $this->resendInvitation($invitation, !is_null($recipient));

        return ApiResponder::successResponse("Invitation resent successfully");
    }

    public function respond(Request $request, Invitation $invitation)
    {
        $this->validate($request, [
            'token' => ['required'],
            'decision' => ['required']
        ]);

        $token = $request->token;
        $decision = $request->decision; // accept or reject

        // check if invitation belongs to them

        $this->authorize('respond', $invitation);

        ///check to make sure tokens match

        if ($invitation->token != $token) {
            return ApiResponder::failureResponse("Invalid Token", 401);
        }

        if ($decision != 'reject') {
            $this->invitations->addUserToProject($invitation->project, auth()->id());
        }

        $invitation->delete();

        return ApiResponder::successResponse("Successful");
    }

    public function destroy(Invitation $invitation)
    {
        $this->authorize('delete', $invitation);

        $invitation->delete();

        return ApiResponder::successResponse("Deleted");
    }

    protected function createInvitation(bool $user_exists, Project $project, string $email)
    {
        $invitation = $this->invitations->create([
            'project_id' => $project->id,
            'sender_id' => auth()->id(),
            'recipient_email' => $email,
            'token' => md5(uniqid(microtime()))
        ]);

        Mail::to($email)->send(new sendInvitationToJoinProject($invitation, $user_exists));
    }

    protected function resendInvitation(Invitation $invitation, bool $user_exists)
    {
        Mail::to($invitation->recipient_email)->send(new sendInvitationToJoinProject($invitation, $user_exists));
    }
}
