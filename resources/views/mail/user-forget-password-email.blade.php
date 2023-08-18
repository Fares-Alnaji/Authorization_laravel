<x-mail::message>
# Welcome, {{$name}}

You have requested to reset your password.

<x-mail::panel>
Reset code is: {{$code}}
</x-mail::panel>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
