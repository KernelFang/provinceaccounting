<div class="d-flex gap-1">

    @if (method_exists($model, 'trashed') && $model->trashed())
        {{-- Restore Button (icon-only) --}}
        <form action="{{ route($routePrefix . '.restore', $model->id) }}" method="POST" style="display:inline">
            @csrf
            <button type="submit" class="btn btn-warning btn-sm" title="Restore" aria-label="Restore">
                <span class="fas fa-undo"></span>
            </button>
        </form>

        {{-- Force Delete Button (icon-only) --}}
        <form action="{{ route($routePrefix . '.force-delete', $model->id) }}" method="POST" style="display:inline"
            onsubmit="return confirm('⚠️ This will permanently delete {{ class_basename($model) }} and all related records. Continue?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" title="Force Delete" aria-label="Force Delete">
                <span class="fas fa-trash-alt"></span>
            </button>
        </form>
    @else
        {{-- Soft Delete Button (icon-only) --}}
        <form action="{{ route($routePrefix . '.destroy', $model->id) }}" method="POST" style="display:inline"
            onsubmit="return confirm('Soft delete this {{ class_basename($model) }}?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm" title="Soft Delete" aria-label="Soft Delete">
                <span class="fas fa-trash"></span>
            </button>
        </form>
    @endif

</div>
