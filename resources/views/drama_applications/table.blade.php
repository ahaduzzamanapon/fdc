<div class="table-responsive">
    <table class="table table_data" id="filmApplications-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Film Title</th>
                <th>Applicant Name</th>
                <th>Organization Name</th>
                <th>Status</th>
                <th>Desk</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($filmApplications as $key => $film)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $film->film_title }}</td>
                <td>{{ $film->applicant_name }}</td>
                <td>{{ $film->organization_name }}</td>
                <td>{{ $film->status }}</td>
                <td>{{ Str::ucfirst(get_role($film->desk_id)->name)}}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary btn-xs dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a href="{{ route('dramaApplications.show', [$film->id]) }}" class="dropdown-item"><i class="im im-icon-Eye" data-placement="top" title="View"></i> View</a>
                            @if ($film->status == 'on process')
                                <a href="{{ route('dramaApplications.forward', [$film->id, 'additional_director_finance']) }}" class="dropdown-item"> <i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="Forward to Additional Director(Sales)"></i>Check And Forward</a>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>



