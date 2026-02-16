<div class="table-responsive">
    <table class="table" id="itemUnits-table">
        <thead>
            <tr>
                <th>Sl</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($ItemDepartments as $key => $itemUnit)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $itemUnit->name }}</td>
                <td>
                    {!! Form::open(['route' => ['itemDepartments.destroy', $itemUnit->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('itemDepartments.show', [$itemUnit->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="View"></i></a>
                        <a href="{{ route('itemDepartments.edit', [$itemUnit->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Pen"  data-toggle="tooltip" data-placement="top" title="Edit"></i></a>

                        {{-- {!! Form::button('<i class="im im-icon-Remove" data-toggle="tooltip" data-placement="top" title="Delete"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!} --}}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
