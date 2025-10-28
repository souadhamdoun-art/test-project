@component('mail::message')
#Thanks for purchasing {{ $course->title }}

If this is your first purshase on {{ config('app.name') }},then a new account was created for you.
Have fun learning!

@component('mail::button', ['url' => route('login')])
    Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

