<x-mail::message>
# Dear Candidate,

Reference your application for Paid Internship Program with BAJK, you are required to appear for test as per schedule given below.

<strong>Test Date & Day: {{ \Carbon\Carbon::parse($user->test_date)->format('d F, Y, l') }}</strong><br>
<strong>Test Start Time: {{ $user->reporting_time }} (PST)</strong><br>
<strong>Duration: 90 Minutes</strong><br>
<strong>Test Centre: {{ $user->test_center }}</strong><br>

# You can sign in using the email address and password you selected during registration to download your call letter.

<x-mail::button :url="'https://pip.bankajk.com/login'">
Login
</x-mail::button>

# For Any Issue: Call During Working Hours 05822-920778

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
