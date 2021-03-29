@component('mail::message')
# Hi

You have been invited to join the project
**{{$invitation->project->name}}**.
Because you are a registered member, you can accept or reject the
invitation in your [Project management console]({{$url}}).

@component('mail::button', ['url' => $url])
Go to Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
