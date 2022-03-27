@component('mail::message')
  # Confirmation of your email address

  Please confirm that {{ $email }} matches your email address. All you need to do is enter the validation
  code to continue your registration.

  Your verification code: {{ $token }}

  Thanks,<br>
  {{ config('app.name') }}
@endcomponent
