@if (session('status'))
<article class="message is-dark">
    <div class="message-body">
        {{ session('status') }}
    </div>
</article>
@endif
@if ($errors->any())
<article class="message is-danger">
    <div class="message-body">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</article>
@endif
