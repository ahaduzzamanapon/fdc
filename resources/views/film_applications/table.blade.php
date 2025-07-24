<div class="table-responsive">
    <table class="table" id="filmApplications-table">
        <thead>
            <tr>
                <th>Id</th>
        <th>Film Title</th>
        <th>Applicant Name</th>
        <th>Father Name</th>
        <th>Mother Name</th>
        <th>Permanent Address</th>
        <th>Present Address</th>
        <th>Nid Number</th>
        <th>Phone Number</th>
        <th>Email</th>
        <th>Organization Name</th>
        <th>Organization Address</th>
        <th>Organization Phone</th>
        <th>Organization Email</th>
        <th>Bank Account Info</th>
        <th>Film Serial No</th>
        <th>Production Start Date</th>
        <th>Budget Amount</th>
        <th>Service Type</th>
        <th>Nominee Name</th>
        <th>Nominee Relation</th>
        <th>Film Duration</th>
        <th>Set Design</th>
        <th>Equipment Rental</th>
        <th>Editing</th>
        <th>Color Grading</th>
        <th>Vfx</th>
        <th>Digital Camera</th>
        <th>Digital Lab</th>
        <th>Approx Cost General</th>
        <th>Approx Cost Animation</th>
        <th>Approx Cost Shortfilm</th>
        <th>Approx Cost Others</th>
        <th>Film Type</th>
        <th>Org Type</th>
        <th>Banner Name</th>
        <th>Freedom Film Info</th>
        <th>Previous Films Info</th>
        <th>Board Member Status</th>
        <th>Director Name</th>
        <th>Director Nid</th>
        <th>Cameraman Name</th>
        <th>Main Cast</th>
        <th>Foreign Participation</th>
        <th>Script Writer Name</th>
        <th>Created At</th>
        <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($filmApplications as $key => $filmApplication)
            <tr>
                <td>{{ $filmApplication->id }}</td>
            <td>{{ $filmApplication->film_title }}</td>
            <td>{{ $filmApplication->applicant_name }}</td>
            <td>{{ $filmApplication->father_name }}</td>
            <td>{{ $filmApplication->mother_name }}</td>
            <td>{{ $filmApplication->permanent_address }}</td>
            <td>{{ $filmApplication->present_address }}</td>
            <td>{{ $filmApplication->nid_number }}</td>
            <td>{{ $filmApplication->phone_number }}</td>
            <td>{{ $filmApplication->email }}</td>
            <td>{{ $filmApplication->organization_name }}</td>
            <td>{{ $filmApplication->organization_address }}</td>
            <td>{{ $filmApplication->organization_phone }}</td>
            <td>{{ $filmApplication->organization_email }}</td>
            <td>{{ $filmApplication->bank_account_info }}</td>
            <td>{{ $filmApplication->film_serial_no }}</td>
            <td>{{ $filmApplication->production_start_date }}</td>
            <td>{{ $filmApplication->budget_amount }}</td>
            <td>{{ $filmApplication->service_type }}</td>
            <td>{{ $filmApplication->nominee_name }}</td>
            <td>{{ $filmApplication->nominee_relation }}</td>
            <td>{{ $filmApplication->film_duration }}</td>
            <td>{{ $filmApplication->set_design }}</td>
            <td>{{ $filmApplication->equipment_rental }}</td>
            <td>{{ $filmApplication->editing }}</td>
            <td>{{ $filmApplication->color_grading }}</td>
            <td>{{ $filmApplication->vfx }}</td>
            <td>{{ $filmApplication->digital_camera }}</td>
            <td>{{ $filmApplication->digital_lab }}</td>
            <td>{{ $filmApplication->approx_cost_general }}</td>
            <td>{{ $filmApplication->approx_cost_animation }}</td>
            <td>{{ $filmApplication->approx_cost_shortfilm }}</td>
            <td>{{ $filmApplication->approx_cost_others }}</td>
            <td>{{ $filmApplication->film_type }}</td>
            <td>{{ $filmApplication->org_type }}</td>
            <td>{{ $filmApplication->banner_name }}</td>
            <td>{{ $filmApplication->freedom_film_info }}</td>
            <td>{{ $filmApplication->previous_films_info }}</td>
            <td>{{ $filmApplication->board_member_status }}</td>
            <td>{{ $filmApplication->director_name }}</td>
            <td>{{ $filmApplication->director_nid }}</td>
            <td>{{ $filmApplication->cameraman_name }}</td>
            <td>{{ $filmApplication->main_cast }}</td>
            <td>{{ $filmApplication->foreign_participation }}</td>
            <td>{{ $filmApplication->script_writer_name }}</td>
            <td>{{ $filmApplication->created_at }}</td>
            <td>{{ $filmApplication->updated_at }}</td>
                <td>
                    {!! Form::open(['route' => ['filmApplications.destroy', $filmApplication->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('filmApplications.show', [$filmApplication->id]) }}" class='btn btn-outline-primary btn-xs'><i class="im im-icon-Eye" data-placement="top" title="View"></i></a>
                        <a href="{{ route('filmApplications.edit', [$filmApplication->id]) }}" class='btn btn-outline-primary btn-xs'><i
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
