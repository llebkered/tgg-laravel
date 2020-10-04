@if (session()->has('success_message'))
<section class="section content">
    <div class="container">
        <div class="message is-success is-light">
            <div class="message-body">
                {{ session()->get('success_message') }}
            </div>

        </div>
    </div>
</section>
@endif

@if (session()->has('warning_message'))
<section class="section content">
    <div class="container">
        <div class="message is-warning is-light">
            <div class="message-body">
                {{ session()->get('warning_message') }}
            </div>
        </div>
    </div>
</section>
@endif

@if (session()->has('danger_message'))
<section class="section content">
    <div class="container">
        <div class="message is-danger is-light">
            <div class="message-body">
                {{ session()->get('danger_message') }}
            </div>
        </div>
    </div>
</section>
@endif
