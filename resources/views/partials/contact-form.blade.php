<form action="" method="POST">
    @csrf
    @honeypot

    <div class="field">
        <label class="label">Name</label>
        <div class="control">
            <input class="input is-medium" type="text" name="name" value="{{ old('name') }}">
        </div>
    </div>
    <div class="field">
        <label class="label">Email</label>
        <div class="control">
            <input class="input is-medium" type="text" name="email" value="{{ old('email') }}">
        </div>
    </div>
    <div class="field">
        <label class="label">Subject</label>
        <div class="control">
            <input class="input is-medium" type="text" name="subject" value="{{ old('subject') }}">
        </div>
    </div>
    <div class="field">
        <label class="label">Phone</label>
        <div class="control">
            <input class="input is-medium" type="text" name="phone" value="{{ old('phone') }}">
        </div>
    </div>
    <div class="field">
        <label class="label">Message</label>
        <div class="control">
            <textarea class="textarea is-medium" name="message">{{ old('message') }}</textarea>
        </div>
    </div>
    <div class="g-recaptcha" data-sitekey="6LcN_sESAAAAAOWD5PSJ1y_QePb-delgio5edjnF"></div>
    <br />

    <div class="control">
        <button type="submit" class="button is-link is-fullwidth has-text-weight-medium is-medium">Send
            Message</button>
    </div>
</form>
