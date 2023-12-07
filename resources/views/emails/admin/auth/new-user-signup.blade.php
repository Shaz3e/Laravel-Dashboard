<x-mail::message>
# New User Signup

First Name: **{{ $mailData['first_name'] }}**<br>
Last Name:  **{{ $mailData['last_name'] }}**<br>
Email: **{{ $mailData['email'] }}**<br>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
