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
            <th>Mobile No</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $noc->token }}</td>
            <td>{{ $noc->status }}</td>
            <td>{{ $noc->name }}</td>
            <td>{{ $noc->producer }}</td>
            <td>{{ $noc->publish_date }}</td>
            <td>{{ $noc->full_name }}</td>
            <td>{{ $noc->designation }}</td>
            <td>{{ $noc->mobile_no }}</td>
        </tr>
    </tbody>
</table>

