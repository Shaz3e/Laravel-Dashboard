<x-mail::message>
# Hi **{{ $mailData['first_name'] }} {{ $mailData['last_name'] }}**,

We are happy to welcome you to {{ DiligentCreators('site_name') }}. To access your account first you need to verify your email.

### Your Login Details 

Your Login Email: **{{ $mailData['email'] }}**<br>
Your Login Password: **{{ $mailData['password'] }}** <br><br>

Please click the button below to verify your email
@component('mail::button', ['url' => $mailData['verification_link']])
Verify Your Email
@endcomponent

<hr>

If you cannot click the button above copy the following url and paste into your browser.

{{ $mailData['verification_link'] }} 

Thanks,<br>
{{ DiligentCreators('site_name') }}
</x-mail::message>
