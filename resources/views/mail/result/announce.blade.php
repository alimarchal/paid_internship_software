<x-mail::message>
#  Dear Candidate, 

The results for The Bank Of Azad Jammu & Kashmir paid internship program are now available.
<br>
To view your result:

<br>Visit the internship portal: https://pip.bankajk.com/login
<br>Log in using your registered email: {{ $user->email }}
<br>Enter your registration password OR use the "Forgot Password" option to reset 

<x-mail::button :url="'https://pip.bankajk.com/login'">
Login
</x-mail::button>

This is an automated email notification. Please do not reply to this message.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
