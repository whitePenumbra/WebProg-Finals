@component('mail::message')
# {!!$user!!} commented on your post!

<b>{!!$user!!}</b> left a comment on your post <b>{!!$post!!}</b>:
<br>
<hr>
{!!$comment!!}
<hr>

@component('mail::button', ['url' => config('app.url')])
Visit FGO Forums Now
@endcomponent
@endcomponent
