<div class="table-responsive">

    @php
        $categories = \App\Models\ItemCategory::all();
        //dd($categories);
    @endphp

    {{-- Category Filter --}}
    <div class="mb-3">
        <label for="categoryFilter" class="form-label">Filter by Category:</label>
        <select id="categoryFilter" class="form-select" style="max-width: 300px;">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->name_bn }}">{{ $cat->name_bn }}</option>
            @endforeach
        </select>
    </div>

    <table class="table" id="items-table">
        <thead>
            <tr>
                <th>Sl</th>
                <th>Name</th>
                <th>Category</th>
                <th>Amount</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($items as $key => $item)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $item->name_bn }}</td>
                <td>{{ $item->cat_name_bn }}</td>
                <td>{{ $item->amount }}</td>
                <td>{{ $item->description }}</td>
                <td>
                    {!! Form::open(['route' => ['items.destroy', $item->id], 'method' => 'delete', 'id' => 'delete-form-'.$item->id]) !!}
                    <div class='btn-group'>
                        <a href="{{ route('items.show', [$item->id]) }}" class='btn btn-outline-primary btn-xs'>
                            <i class="im im-icon-Eye" title="View"></i>
                        </a>
                        <a href="{{ route('items.edit', [$item->id]) }}" class='btn btn-outline-primary btn-xs'>
                            <i class="im im-icon-Pen" title="Edit"></i>
                        </a>
                        {!! Form::button('<i class="im im-icon-Remove" title="Delete"></i>', [
                            'type' => 'button',
                            'class' => 'btn btn-outline-danger btn-xs',
                            'onclick' => "confirmDelete('delete-form-".$item->id."')"
                        ]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@section('scripts')

<script>
$(document).ready(function () {
    // Initialize DataTable
    var table = $('#items-table').DataTable({
        responsive: true
    });

    // Category filter
    $('#categoryFilter').on('change', function () {
        var category = $(this).val();
        table.column(2).search(category).draw();
    });
});

// SweetAlert Delete Confirmation
function confirmDelete(formId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will permanently delete the item.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endsection
