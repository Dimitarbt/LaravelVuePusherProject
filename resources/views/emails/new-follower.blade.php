@component('mail::message')
# Introduction

<h2>Hi,</h2>

<p>{{ $follower['name'] }} {{ $msg }}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
