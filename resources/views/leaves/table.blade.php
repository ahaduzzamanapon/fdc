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
                                <span class="badge badge-success"  style="font-size: 12px">{{ 'প্রেরণ' }}</span>
                            @elseif($leave->status == 2)
                                <span class="badge badge-success"  style="font-size: 12px">{{ 'প্রেরণ প্রেরণ' }}</span>
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
                                    @if(in_array(Auth::user()->staff_class, [1, 2]))
                                        <a href="{{ route('forward.to.dept.head', $leave->id) }}" class='dropdown-item'><i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="প্রেরণ করুন"></i> প্রেরণ করুন</a>
                                    @else
                                        <a href="{{ route('forward.to.dept.finance', $leave->id) }}" class='dropdown-item'><i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="প্রেরণ করুন"></i> প্রেরণ করুন</a>
                                    @endif
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
