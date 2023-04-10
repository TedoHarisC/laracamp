<x-mail::message>
# Register Camp: {{$checkout->Camp->title}}

Hi {{$checkout->User->name}}
<br>
Thank You for register on <b>{{ $checkout->Camp->title }}</b>, please see payment instruction by click the button below.

<x-mail::button :url="''">
Get Invoice
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
