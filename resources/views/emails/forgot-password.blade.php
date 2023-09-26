@component('mail::message')
# Your Password has been reset

Below is your new password

<h1 style='text-align:center'>{{ $new_password }}</h1>

Use this as your new password

Regards,<br>
{{ config('app.name') }}

@endcomponent