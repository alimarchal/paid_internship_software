<x-mail::message>
# Result Announced

We're pleased to inform you that the results for the bank's paid internship program are now available online. To view your result, please log in to the internship portal using your credentials.

<x-mail::button :url="'https://pip.bankajk.com/login'">
Login
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
