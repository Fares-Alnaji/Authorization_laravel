<x-mail::message>
# Welcome {{$name}}

We are happy to see you here,

<x-mail::panel>
This account password is:{{$password}}.
</x-mail::panel>

<x-mail::button :url="''">
Open CMS
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
