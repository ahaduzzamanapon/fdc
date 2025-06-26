<div class="table-responsive">
    <table class="table table_data" id="leaves-table">
        <thead>
            <tr>
                <th>ক্রমিক</th>
                <th>নাম</th>
                <th>শুরুর তারিখ</th>
                <th>শেষ তারিখ</th>
                <th>অনু. শুরুর তারিখ</th>
                <th>অনু. শেষ তারিখ</th>
                <th>অনু.মোট দিন</th>
                <th>অবস্থা</th>
                <th>ক্রিয়া</th>
            </tr>
        </thead>
        <tbody>
            @foreach($leaves as $key => $leave)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $leave->user_name }}</td>
                    <td>{{ date('d M Y', strtotime($leave->from_date)) }}</td>
                    <td>{{ date('d M Y', strtotime($leave->to_date)) }}</td>
                    <td>{{ date('d M Y', strtotime($leave->approved_from_date)) }}</td>
                    <td>{{ date('d M Y', strtotime($leave->approved_to_date)) }}</td>
                    <td>{{ $leave->approved_total_day }}</td>
                    <td>
                        @if($leave->status == 'draft')
                            <span class="badge badge-warning" style="text-transform: capitalize">{{ strtoupper($leave->status) }}</span>
                        @elseif($leave->status == 'approved')
                            <span class="badge badge-success"  style="text-transform: capitalize">{{ strtoupper($leave->status) }}</span>
                        @else
                            <span class="badge badge-danger"  style="text-transform: capitalize">{{ strtoupper($leave->status) }}</span>
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
        </tbody>
    </table>
</div>
