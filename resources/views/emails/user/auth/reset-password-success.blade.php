<x-mail::message>
# Hi **{{ $mailData['name'] }}**,

You have successfully reset your password.

New Password: **{{ $mailData['password'] }}**


Thanks,<br>
{{ DiligentCreators('site_name') }}
</x-mail::message>
