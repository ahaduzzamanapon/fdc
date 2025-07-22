<div class="table-responsive">
    <table class="table table_data" id="leaves-table">
        <thead>
            <tr>
                <th>ক্রমিক</th>
                <th>নাম</th>
                <th>শুরুর তারিখ</th>
                <th>শেষ তারিখ</th>
                <th>অনু.শুরুর তারিখ</th>
                <th>অনু.শেষ তারিখ</th>
                <th>অনু.মোট দিন</th>
                <th>অবস্থা</th>
                <th>ক্রিয়া</th>
            </tr>
        </thead>
        <tbody>
            @if(Auth::user()->user_role == 1)
                @php $i = 1; @endphp
                @foreach($leaves as $key => $leave)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $leave->user_name }}</td>
                        <td>{{ date('d M Y', strtotime($leave->from_date)) }}</td>
                        <td>{{ date('d M Y', strtotime($leave->to_date)) }}</td>
                        <td>{{ date('d M Y', strtotime($leave->approved_from_date)) }}</td>
                        <td>{{ date('d M Y', strtotime($leave->approved_to_date)) }}</td>
                        <td>{{ $leave->approved_total_day }}</td>
                        <td>
                            @if($leave->status == 0)
                                <span class="badge badge-warning" style="font-size: 12px">{{ 'ড্রাফ্ট' }}</span>
                            @elseif($leave->status == 1)
                                <span class="badge badge-success"  style="font-size: 12px">{{ 'প্রেরণ' }}</span>
                            @elseif($leave->status == 2)
                                <span class="badge badge-success"  style="font-size: 12px">{{ 'প্রেরণ' }}</span>
                            @elseif($leave->status == 3)
                                <span class="badge badge-success"  style="font-size: 12px">{{ 'অনুমোদন' }}</span>
                            @else
                                <span class="badge badge-danger"  style="font-size: 12px">{{ 'বাতিল' }}</span>
                            @endif
                        </td>
                        <td>
                            <div class='dropdown'>
                                <button class='btn btn-outline-primary btn-xs dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                    ক্রিয়া
                                </button>
                                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                    <a href="{{ route('leaves.show', [$leave->id]) }}" class='dropdown-item'><i class="im im-icon-Eye" data-placement="top" title="দেখুন"></i> দেখুন</a>
                                    <a href="{{ route('leaves.edit', [$leave->id]) }}" class='dropdown-item'><i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="সম্পাদনা করুন"></i> সম্পাদনা করুন</a>
                                    {!! Form::open(['route' => ['leaves.destroy', $leave->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                        {!! Form::button('<i class="im im-icon-Remove" data-toggle="tooltip" data-placement="top" title="মুছে ফেলুন"></i> মুছে ফেলুন', ['type' => 'submit', 'class' => 'dropdown-item', 'onclick' => "return confirm('আপনি কি নিশ্চিত?')"]) !!}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                @php $i = 1; @endphp
                @foreach($leaves as $key => $leave)
                    @if ($leave->employee_id == Auth::user()->id)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $leave->user_name }}</td>
                        <td>{{ date('d M Y', strtotime($leave->from_date)) }}</td>
                        <td>{{ date('d M Y', strtotime($leave->to_date)) }}</td>
                        <td>{{ date('d M Y', strtotime($leave->approved_from_date)) }}</td>
                        <td>{{ date('d M Y', strtotime($leave->approved_to_date)) }}</td>
                        <td>{{ $leave->approved_total_day }}</td>
                        <td>
                            @if($leave->status == 0)
                                <span class="badge badge-warning" style="font-size: 12px">{{ 'ড্রাফ্ট' }}</span>
                            @elseif($leave->status == 1)
                                <span class="badge badge-primary"  style="font-size: 12px">{{ 'চলমান' }}</span>
                            @elseif($leave->status == 2)
                                <span class="badge badge-primary"  style="font-size: 12px">{{ 'ডাইরেক্টর অনুমোদিত' }}</span>
                            @elseif($leave->status == 3)
                                <span class="badge badge-success"  style="font-size: 12px">{{ 'অনুমোদন' }}</span>
                            @else
                                <span class="badge badge-danger"  style="font-size: 12px">{{ 'বাতিল' }}</span>
                            @endif
                            </td>
                        <td>
                            <div class='dropdown'>
                                <button class='btn btn-outline-primary btn-xs dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                    ক্রিয়া
                                </button>
                                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                    <a href="{{ route('leaves.show', [$leave->id]) }}" class='dropdown-item'><i class="im im-icon-Eye" data-placement="top" title="দেখুন"></i> দেখুন</a>
                                    @if($leave->status == 0)
                                    <a href="{{ route('leaves.edit', [$leave->id]) }}" class='dropdown-item'><i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="সম্পাদনা করুন"></i> সম্পাদনা করুন</a>
                                    @endif

                                    @if($leave->status == 0)
                                        <button onclick="forward({{ $leave->id }})" data-toggle="modal" data-target="#exampleModal" href="#" class='dropdown-item'><i class="im im-icon-Forward" data-toggle="tooltip" data-placement="top" title="প্রেরণ করুন"> </i>প্রেরণ করুন</button>
                                    @endif

                                    {!! Form::open(['route' => ['leaves.destroy', $leave->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                        {!! Form::button('<i class="im im-icon-Remove" data-toggle="tooltip" data-placement="top" title="মুছে ফেলুন"></i> মুছে ফেলুন', ['type' => 'submit', 'class' => 'dropdown-item', 'onclick' => "return confirm('আপনি কি নিশ্চিত?')"]) !!}
                                    {!! Form::close() !!}

                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Employee List</h5>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Data will be loaded here by AJAX -->
                <div id="emp-table-container"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal();">Close</button>
                <button type="button" onclick="submit_emp_selection()" class="btn btn-primary" id="submit-emp-selection">প্রেরণ করুন</button>
            </div>
        </div>
    </div>
</div>

<script>
    function closeModal() {
        $('#exampleModal').modal('hide');
        // Remove modal-backdrop if still present
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('padding-right', '');
    }

    function forward(id) {
        $.ajax({
            url: "{{ route('leaves.get_emp_by_dept', '') }}/",
            type: "POST",
            data: {
                id: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                // Expecting response: { leave_id: ..., employees: [...] }
                let leaveId = response.leave_id || '';
                let employees = Array.isArray(response.get_emp_by_dept) ? response.get_emp_by_dept : [];
                let html = `
                    <div class="mb-2">
                        <input type="hidden" id="leave_id" value="${leaveId}">
                        <input type="checkbox" id="select-all-emp" />
                        <label for="select-all-emp">সব নির্বাচন করুন</label>
                    </div>
                    <form id="emp-select-form">
                        <div style="max-height: 260px; overflow-y: auto;">
                        <table class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>নির্বাচন</th>
                                    <th>নাম</th>
                                </tr>
                            </thead>
                            <tbody>
                `;
                employees.forEach(function(emp, idx) {
                    html += `
                        <tr>
                            <td>
                                <input type="checkbox" class="emp-checkbox" name="emp_ids[]" value="${emp.id}" id="emp-${idx}">
                            </td>
                            <td>
                                <label for="emp-${idx}">${emp.name_bn ? emp.name_bn : ''}</label>
                            </td>
                        </tr>
                    `;
                });
                html += `
                            </tbody>
                        </table>
                        </div>
                    </form>
                `;
                $('#emp-table-container').html(html);
                $('#exampleModal').modal('show');
                // Ensure modal events are properly initialized
                $('#exampleModal').on('hidden.bs.modal', function () {
                    $('#emp-table-container').html('');
                    // Remove modal-backdrop if still present
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open').css('padding-right', '');
                });

                // Select all functionality
                $('#select-all-emp').on('change', function() {
                    $('.emp-checkbox').prop('checked', this.checked);
                });
                // Uncheck "select all" if any single is unchecked
                $(document).on('change', '.emp-checkbox', function() {
                    if (!this.checked) {
                        $('#select-all-emp').prop('checked', false);
                    } else if ($('.emp-checkbox:checked').length === $('.emp-checkbox').length) {
                        $('#select-all-emp').prop('checked', true);
                    }
                });
            },
            error: function(xhr, status, error) {
                $('#emp-table-container').html('<div class="alert alert-danger">ডেটা লোড করা যায়নি</div>');
            }
        });
    }
</script>

<script>
    function submit_emp_selection() {
        let leave_id = $('#leave_id').val();
        let selectedEmpIds = [];
        $('#emp-select-form input[name="emp_ids[]"]:checked').each(function() {
            selectedEmpIds.push($(this).val());
        });

        if (selectedEmpIds.length === 0) {
            alert('কোনো কর্মচারী নির্বাচন করা হয়নি।');
            return;
        }

        $.ajax({
            url: "{{ route('leaves.forward.to.dept.emp', '') }}/" ,
            type: "POST",
            data: {
                emp_ids: selectedEmpIds.join(','),
                leave_id:leave_id,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    closeModal();
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert('প্রেরণ করতে সমস্যা হয়েছে। দয়া করে আবার চেষ্টা করুন।');
                }
            },
            error: function(xhr, status, error) {
                alert('প্রেরণ করতে সমস্যা হয়েছে। দয়া করে আবার চেষ্টা করুন।');
            }
        });
    }
</script>
