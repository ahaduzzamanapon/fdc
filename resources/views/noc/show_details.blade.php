<table class="table table-data">
    <thead>
        <tr>
            <th>Registration No</th>
            <th>Status</th>
            <th>Name</th>
            <th>Producer</th>
            <th>Publish Date</th>
            <th>Full Name</th>
            <th>Designation</th>
            <th>Download</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $noc->token }}</td>
            <td>{{ $noc->status }}</td>
            <td>{{ $noc->name }}</td>
            <td>{{ $noc->producer }}</td>
            <td>{{ date('d-m-Y', strtotime($noc->publish_date)) ?? '' }}</td>
            <td>{{ $noc->full_name }}</td>
            <td>{{ $noc->designation }}</td>
            <td> <a href="{{ route('noc.download', $noc->token) }}" target='_blank'>Download</a> </td>
        </tr>
    </tbody>
</table>

