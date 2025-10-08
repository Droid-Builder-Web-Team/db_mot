<form method="POST" action="{{ url('two-factor-challenge') }}">
    @csrf

    <label for="code">Two-Factor Code</label>
    <input id="code" type="text" name="code" required autofocus>

    @error('code')
        <span>{{ $message }}</span>
    @enderror

    <button type="submit">Log in</button>

    <p>
        Lost your device? <a href="#" onclick="document.getElementById('recovery-form').style.display='block'; return false;">Use a recovery code.</a>
    </p>

</form>

<form id="recovery-form" method="POST" action="{{ url('two-factor-challenge') }}" style="display:none;">
    @csrf
    <label for="recovery_code">Recovery Code</label>
    <input id="recovery_code" type="text" name="recovery_code" required>
    <button type="submit">Log in with Recovery Code</button>
</form>

