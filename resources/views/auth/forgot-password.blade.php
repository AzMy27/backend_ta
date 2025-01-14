<!-- resources/views/auth/forgot-password.blade.php -->
<form method="POST" action="{{ route('password.email') }}">
  @csrf
  <div>
      <label for="email">Email</label>
      <input type="email" name="email" id="email" required>
  </div>

  @error('email')
      <span>{{ $message }}</span>
  @enderror

  <button type="submit">
      Kirim Link Reset Password
  </button>
</form>