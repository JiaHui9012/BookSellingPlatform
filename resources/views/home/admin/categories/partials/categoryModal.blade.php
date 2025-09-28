<div class="modal fade" id="categoryModal{{ $type }}" tabindex="-1" aria-labelledby="categoryModalLabel{{ $type }}" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ $type === 'Add' ? route('categories.store') : '' }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="modal-content"
              id="categoryForm{{ $type }}">
            @csrf
            @if($type === 'Edit')
                @method('PUT')
            @endif

            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel{{ $type }}">{{ $type }} Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" id="categoryModalBody{{ $type }}">
                @if($type === 'Add')
                @include('home.admin.categories.partials.categoryFields')
                @endif
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">{{ $type }} Category</button>
            </div>
        </form>
    </div>
</div>
