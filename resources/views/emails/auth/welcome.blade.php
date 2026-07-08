<x-mail::message>
# Welcome, {{ $userName }}

Your account has been created successfully on **{{ config('app.name') }}**.

You can sign in to your account using the button below.

<x-mail::button :url="$loginUrl">
Login to your account
</x-mail::button>

If you did not create this account, please ignore this email.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>