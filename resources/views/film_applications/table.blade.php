<div class="table-responsive">
    <table class="table table_data" id="filmApplications-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>Film Title</th>
                <th>Applicant Name</th>
                <th>Organization Name</th>
                <th>Desk</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($filmApplications as $key => $filmApplication)
            <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $filmApplication->film_title }}</td>
            <td>{{ $filmApplication->applicant_name }}</td>
            <td>{{ $filmApplication->organization_name }}</td>
            <td>{{ Str::ucfirst($filmApplication->desk )}}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary btn-xs dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Actions
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @if ($filmApplication->state == 'forward' && $filmApplication->desk == 'director_production' && can('director_production'))
                            <a href="{{ route('filmApplications.forward', [$filmApplication->id, 'additional_director_finance']) }}" class="dropdown-item">
                                <i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="Forward to Additional Director(Sales)"></i>Forward to Additional Director Finance</a>
                            @endif

                            @if ($filmApplication->state == 'forward' && $filmApplication->desk == 'additional_director_finance' && can('additional_director_finance'))
                            <a href="{{ route('filmApplications.forward', [$filmApplication->id, 'assistant_director_admin']) }}" class="dropdown-item">
                                <i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="Forward to Additional Director(Sales)"></i>Forward to Assistant Director Admin</a>
                            @endif

                            @if ($filmApplication->state == 'forward' && $filmApplication->desk == 'assistant_director_admin' && can('assistant_director_admin'))
                            <a href="{{ route('filmApplications.forward', [$filmApplication->id, 'assistant_production']) }}" class="dropdown-item">
                                <i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="Forward to Additional Director(Sales)"></i>Forward to Assistant Production</a>
                            @endif

                            @if ($filmApplication->state == 'back' && $filmApplication->desk == 'assistant_production'  && can('assistant_production'))
                            <a href="{{ route('filmApplications.back', [$filmApplication->id, 'assistant_director_admin']) }}" class="dropdown-item"><i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="Forward to Additional Director(Sales)"></i>Back to Assistant Director Admin</a>
                            @endif

                            @if ($filmApplication->state == 'back' && $filmApplication->desk == 'assistant_director_admin'  && can('assistant_director_admin'))
                            <a href="{{ route('filmApplications.back', [$filmApplication->id, 'additional_director_finance']) }}" class="dropdown-item"><i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="Forward to Additional Director(Sales)"></i>Back to Additional Director Finance</a>
                            @endif


                            @if ($filmApplication->state == 'back' && $filmApplication->desk == 'additional_director_finance' && can('additional_director_finance'))
                            <a href="{{ route('filmApplications.back', [$filmApplication->id, 'director_production']) }}" class="dropdown-item"><i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="Forward to Additional Director(Sales)"></i>Back to Director Production</a>
                            @endif
                            
                            @if ($filmApplication->state == 'back' && $filmApplication->desk == 'director_production' && can('director_production'))
                            <a href="{{ route('filmApplications.final_forward_to_md', [$filmApplication->id, 'md']) }}" class="dropdown-item"><i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="Forward to MD"></i> Forward to MD</a>
                            @endif

                            @if ($filmApplication->state == 'back' && $filmApplication->desk == 'All Desks Completed Waiting for MD Approval' && can('md'))
                            <a href="{{ route('filmApplications.approve_md', [$filmApplication->id, 'md']) }}" class="dropdown-item"><i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="Forward to MD"></i> Approve</a>
                            @endif



                            @if ($filmApplication->state == 'back' && $filmApplication->desk == 'MD Approved')
                                <a class="dropdown-item cursor-pointer" onclick="showMakePaymentModal({{ $filmApplication->id }})"><i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="Make Payment"></i> Make Payment</a>
                                <a href="{{ route('filmApplications.payment_data', [$filmApplication->id]) }}" class="dropdown-item"><i class="im im-icon-Eye" data-toggle="tooltip" data-placement="top"></i> Payment Data</a>
                            @endif

                            <a href="{{ route('filmApplications.show', [$filmApplication->id]) }}" class="dropdown-item"><i class="im im-icon-Eye" data-placement="top" title="View"></i> View</a>
                            @if ($filmApplication->state == 'forward' && $filmApplication->desk == 'director_production')
                                <a href="{{ route('filmApplications.edit', [$filmApplication->id]) }}" class="dropdown-item"><i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="Edit"></i> Edit</a>
                                {!! Form::open(['route' => ['filmApplications.destroy', $filmApplication->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                {!! Form::button('<i class="im im-icon-Remove" data-toggle="tooltip" data-placement="top" title="Delete"></i> Delete', ['type' => 'submit', 'class' => 'dropdown-item', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                {!! Form::close() !!}
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>



