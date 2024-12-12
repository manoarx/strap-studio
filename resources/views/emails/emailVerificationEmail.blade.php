@component('mail::message')
@if($user_type == 'user')
# Username : {{ $user_name }}

# Password : {{ $user_name }}
@endif

# Verify your email address

Please click the button below to verify your email address:

@component('mail::button', ['url' => $verification_url])
Verify Email
@endcomponent

If you did not create an account, no further action is required.

Thanks,<br>
{{ config('app.name') }}
@endcomponent

