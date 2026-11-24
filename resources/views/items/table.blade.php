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
                <th>{{ __('messages.action_label') }}</th>
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
                    <div class="dropdown">
                        <button class="btn btn-outline-primary btn-xs dropdown-toggle" type="button"
                            id="dropdownMenuButton-{{ $item->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('messages.actions_button') }}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton-{{ $item->id }}">
                            <a href="{{ route('items.show', [secure_hash_id($item->id)]) }}" class="dropdown-item">
                                <i class="im im-icon-Eye" title="View"></i> {{ __('messages.view_label') }}
                            </a>
                            <a href="{{ route('items.edit', [secure_hash_id($item->id)]) }}" class="dropdown-item">
                                <i class="im im-icon-Pen" title="Edit"></i> {{ __('messages.edit') }}
                            </a>
                            <form action="{{ route('items.pushRateCard', secure_hash_id($item->id)) }}" method="POST" style="margin: 0;" onsubmit="return confirm('আপনি কি এই আইটেমটি Rate Card হিসেবে BFDC Accounting-এ পুশ করতে চান?');">
                                @csrf
                                <button type="submit" class="dropdown-item text-primary" style="background: none; border: none; width: 100%; text-align: left; padding: 0.25rem 1.5rem; cursor: pointer;">
                                    <i class="im im-icon-Upload"></i> রেট কার্ড পুশ করুন
                                </button>
                            </form>
                            <a href="javascript:void(0)" class="dropdown-item text-danger" onclick="confirmDelete('delete-form-{{ $item->id }}')">
                                <i class="im im-icon-Remove" title="Delete"></i> {{ __('messages.delete_button') }}
                            </a>
                        </div>
                    </div>
                    {!! Form::open(['route' => ['items.destroy', secure_hash_id($item->id)], 'method' => 'delete', 'id' => 'delete-form-'.$item->id, 'style' => 'display:none;']) !!}
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
