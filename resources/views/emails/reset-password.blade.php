@component('mail::message')
# Introduction

The body of your message.

{{$token}}

@component('mail::button', ['url' => config('app.url') . '/reset-password?token=' .$token])
Click Here to reset your password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
