<div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title"
        value="{{ $book->title ?? old('title') }}"
        class="form-control" required>
</div>
<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control">{{ $book->description ?? old('description') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Price</label>
    <input type="number" name="price"
        value="{{ $book->price ?? old('price') }}"
        step="0.01" class="form-control" required>
</div>
<div class="mb-3">
    <label class="form-label">Stock</label>
    <input type="number" name="stock"
        value="{{ $book->stock ?? old('stock') }}"
        class="form-control" required>
</div>
<div class="mb-3">
    <label class="form-label">Cover Image</label>
    <input type="file" name="cover" class="form-control">
</div>