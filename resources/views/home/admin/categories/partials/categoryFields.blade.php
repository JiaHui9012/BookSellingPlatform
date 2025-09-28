<div class="mb-3">
    <label class="form-label">Name</label>
    <input type="text" name="name"
        value="{{ $category->name ?? old('name') }}"
        class="form-control" required>
</div>
<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control">{{ $category->description ?? old('description') }}</textarea>
</div>