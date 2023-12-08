<x-mail::message>
# Hi **{{ $mailData['name'] }}**,

We have received your password reset request if you did not made this request you can ignore this email.

Please click the button below to reset your password
@component('mail::button', ['url' => $mailData['url']])
Reset Password
@endcomponent

<hr>

If you cannot click the button above copy the following url and paste into your browser.

{{ $mailData['url'] }} 

Thanks,<br>
{{ DiligentCreators('site_name') }}
</x-mail::message>
