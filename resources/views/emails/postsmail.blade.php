@component('mail::message')
    # Introduction

    The body of your message.
    <div>
        @foreach($posts as $post)
            <label>{{ $post->title }}</label>
            <hr>
            <label>{{ $post->description }}</label>
            <hr>
        @endforeach
        <label style="background-color: #0b2e13;">{{ $message }}</label>
    </div>

    @component('mail::button', ['url' => ''])
        Button Text
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
