<div class="content">
    <div class="columns">
        <div class="column">
            <h2>Cart empty</h2>
            <p>There are no items in your cart.</p>
        </div>
        <div class="column">
            @if ($page->image)
            <figure class="image">
                <img src="{{ asset('storage/app/public/' . $page->image)}}" alt="Image: {{ $page->title }}">
            </figure>
            @endif
        </div>
    </div>
</div>
