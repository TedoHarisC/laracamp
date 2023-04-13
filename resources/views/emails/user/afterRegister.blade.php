<x-mail::message>
# Order Shipped

Hi {{$user->name}}!
<br/>
Welcome to Laracamp, your account has been created successfully. Now you can choose your best match camp!

<x-mail::button :url="$url">
Login Here
</x-mail::button>

Thanks
{{ config('app.name') }}
</x-mail::message>