@component('mail::message')
# Introduction

The body of your message.
<div>
   <label>{{$postsmail->title}}</label><hr>
   <label>{{$postsmail->description}}</label><hr>
    <label style="background-color: #0b2e13">{{$message}}</label>
</div>

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
