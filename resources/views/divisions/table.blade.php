<div class="table-responsive">
    <table class="table" id="divisions-table">
        <thead>
            <tr>
                <th>Sl</th>
                <th>Name Bn</th>
                <th>Name En</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($divisions as $key => $division)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $division->name_bn }}</td>
                <td>{{ $division->name_en }}</td>
                <td>{{ $division->status }}</td>
                <td>
                    {!! Form::open(['route' => ['divisions.destroy', $division->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('divisions.show', [$division->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="View"></i></a>
                        <a href="{{ route('divisions.edit', [$division->id]) }}" class='btn btn-outline-primary btn-xs'><i
                                class="im im-icon-Pen"  data-toggle="tooltip" data-placement="top" title="Edit"></i></a>
                        {!! Form::button('<i class="im im-icon-Remove" data-toggle="tooltip" data-placement="top" title="Delete"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
