<input type="hidden" name="user_id" value="{{ $user->id }}">

<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
</div>

<div class="mb-3">
    <label class="form-label">Username</label>
    <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control" required>
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
</div>