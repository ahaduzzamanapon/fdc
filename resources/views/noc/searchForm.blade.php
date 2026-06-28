@extends('welcome')

<style>
    .form-header {
        width: 100%;
        display: flex;
        justify-content: space-between;
        background-color: #98dfe9;
        padding: 20px;
    }

    .form-header p {
        font-size: 18px !important;
        font-weight: bold;
        margin-bottom: 0px !important;
    }

    .card-search {
        padding: 10px 0px !important;
        background: #fff !important;
    }

    .card-body {
        padding: 10px 0px !important;
        background: #fff !important;
        align-items: center;
        padding: 50px !important;
    }

    .card-body-table {
        padding: 10px 0px !important;
        background: #fff !important;
        align-items: center;
    }
</style>

@section('body')
<!-- card section -->
<section class="cardSection" style="background-color: #eaf9fb; padding-bottom: 50px;">
    <div class="container">
        <div class="form-header">
            <p class="fright"> NOC তালিকা </p>
            <p class="fleft"> <a href="{{ route('noc.create') }}">NOC আবেদন ফরম</a></p>
        </div>

        {{-- Search Form --}}
        <div class="card-search">
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <input type="text" name="token_number" id="token_number" class="form-control"
                        placeholder="আবেদন নম্বর লিখুন">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-primary" id="searchSubmit">খুঁলুন</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search Results --}}
        <div class="card-body-table">
            <table class="table table-data">
                <thead>
                    <tr>
                        <th>Registration No</th>
                        <th>Name</th>
                        <th>Producer</th>
                        <th>Publish Date</th>
                        <th>Full Name</th>
                        <th>Designation</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="searchResults">

                </tbody>
            </table>
        </div>

    </div>
</section>

@stop

@push('fontEnd_script')
    <script>
        $('#searchSubmit').click(function (e) {
            e.preventDefault();
            let token_number = $('#token_number').val();
            $.ajax({
                url: "{{ route('noc.ajax.search') }}",
                method: "POST",
                data: { token_number: token_number },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function (res) {
                    if (res.status === 'success') {
                        const downloadUrl = "{{ route('noc.download', ':id') }}"; // placeholder :id
                        const showUrl = "{{ route('noc.show', ':id') }}"; // placeholder :id
                        const payLink = "{{ route('noc.pay', ':id') }}"; // placeholder :id
                        var actionDropdown = `
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Action
                                </button>

                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="${showUrl.replace(':id', res.result.id)}">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                    ${
                                        res.result.status === 'approved' ? `<a class="dropdown-item" href="${payLink.replace(':id', res.result.token)}" target="_blank"> <i class="fa fa-credit-card"></i> Pay </a>` : ''
                                    }
                                    ${
                                        res.result.status === 'paid' ? `<a class="dropdown-item" href="${downloadUrl.replace(':id', res.result.token)}" target="_blank"> <i class="fa fa-download"></i> Download </a>`
                                        : `<span class="dropdown-item text-muted"> <i class="fa fa-ban"></i> Download Not Available </span>`
                                    }
                                </div>
                            </div>
                        </td>`;

                        var row = `
                        <tr>
                            <td>${res.result.token}</td>
                            <td>${res.result.name}</td>
                            <td>${res.result.producer}</td>
                            <td>${res.result.publish_date}</td>
                            <td>${res.result.full_name}</td>
                            <td>${res.result.designation}</td>
                            <td>
                                <span class="badge ${res.result.status === 'approved' ? 'bg-success' : 'bg-warning text-dark'}">
                                    ${res.result.status}
                                </span>
                            </td>
                            ${actionDropdown}
                        </tr>`;
                        $('#searchResults').html(row);
                    } else {
                        $('#searchResults').html(res.result);
                    }
                },
                error: function (err) {
                    console.log(err);
                }
            });
        });
    </script>
@endpush
