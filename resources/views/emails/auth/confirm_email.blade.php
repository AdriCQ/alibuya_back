@component('mail::message')
# @lang('mail.auth.verify_email.title')

@lang('mail.greetings', ['name'=> $user['first_name']])
<br>

@lang('mail.auth.verify_email.body')

@component('mail::button', ['url' => $confirmation_url])
  @lang('mail.auth.verify_email.button')
@endcomponent

@lang('mail.auth.verify_email.url_copy')
@component('mail::panel')
{{ urldecode($confirmation_url) }}
@endcomponent

@lang('mail.bye'),<br>
Soporte de {{ config('app.name') }}
@endcomponent