@component('mail::message')
# {!!$user!!} upvoted your post!

<b>{!!$user!!}</b> upvoted your post <b>{!!$title!!}</b>.

@component('mail::button', ['url' => config('app.url')])
Visit FGO Forums Now
@endcomponent
@endcomponent
