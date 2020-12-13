@component('mail::message')
# @lang('mail.auth.password_reset.title')

@lang('mail.greetings', ['name'=> $user['first_name']])
<br>

@lang('mail.auth.password_reset.body')

@component('mail::button', ['url' => $reset_url])
  @lang('mail.auth.password_reset.button')
@endcomponent

@lang('mail.auth.password_reset.url_copy')
@component('mail::panel')
{{ urldecode($reset_url) }}
@endcomponent

@lang('mail.bye'),<br>
Soporte de {{ config('app.name') }}
@endcomponent