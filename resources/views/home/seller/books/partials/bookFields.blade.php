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
    <label class="form-label">Category</label>
    <select name="category_id" class="form-control px-2 py-1 border rounded">
        <option value="">-- None --</option>
        @foreach($categories as $c)
        <option value="{{ $c->id }}"
            {{ (old('category_id') == $c->id) || (isset($book) && $book->category_id == $c->id) ? 'selected' : '' }}>
            {{ $c->name }}
        </option>
        @endforeach
    </select>
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