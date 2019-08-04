@component('mail::message')
# Verify your email address

Verification link is below

@component('mail::button', ['url' => ''])
Verify Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
