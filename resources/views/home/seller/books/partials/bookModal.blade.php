<div class="modal fade" id="bookModal{{ $type }}" tabindex="-1" aria-labelledby="bookModalLabel{{ $type }}" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ $type === 'Add' ? route('books.store') : '' }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="modal-content"
              id="bookForm{{ $type }}">
            @csrf
            @if($type === 'Edit')
                @method('PUT')
            @endif

            <div class="modal-header">
                <h5 class="modal-title" id="bookModalLabel{{ $type }}">{{ $type }} Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" id="bookModalBody{{ $type }}">
                @if($type === 'Add')
                @include('home.seller.books.partials.bookFields')
                @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">{{ $type }} Book</button>
            </div>
        </form>
    </div>
</div>
