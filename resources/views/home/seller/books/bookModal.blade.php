<div class="modal fade" id="bookModal{{ $type }}{{ $book->id ?? '' }}" tabindex="-1" aria-labelledby="bookModalLabel{{ $type }}" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ $type === 'Add' ? route('books.store') : route('books.update', $book) }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="modal-content">
            @csrfs
            @if($type === 'Edit')
                @method('PUT')
            @endif

            <div class="modal-header">
                <h5 class="modal-title" id="bookModalLabel{{ $type }}">{{ $type }} Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
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
                    <input type="file" name="cover_image" class="form-control">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">{{ $type }} Book</button>
            </div>
        </form>
    </div>
</div>
