@component('mail::message')
# Hi

You have been invited to join the project
**{{$invitation->project->name}}**.
Because you are not yet a registered member, please
[Register for free]({{$url}}), then you can accept or reject the
invitation in your project management console.

@component('mail::button', ['url' => $url])
Register for free
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
