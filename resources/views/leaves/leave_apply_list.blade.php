@extends('layouts.default')

@section('title')
Leaves @parent
@stop

@section('content')

<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')
    <script>
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 3000);
    </script>

    <div class="clearfix"></div>
    <div class="card" width="88vw;">
        <section class="card-header">
            <h5 class="card-title d-inline">ছুটির তালিকা</h5>
        </section>
        <div class="card-body table-responsive">
            <div class="table-responsive">
                <br>
                <table class="table table_data table-bordered" id="leaves-table">
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
                        @php $i = 1; @endphp
                        @foreach($leaves as $key => $leave)
                            @if (($leave->department == Auth::user()->department) && $leave->status ==1)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $leave->name_bn }}</td>
                                <td>{{ date('d M Y', strtotime($leave->from_date)) }}</td>
                                <td>{{ date('d M Y', strtotime($leave->to_date)) }}</td>
                                <td>{{ date('d M Y', strtotime($leave->approved_from_date)) }}</td>
                                <td>{{ date('d M Y', strtotime($leave->approved_to_date)) }}</td>
                                <td>{{ $leave->approved_total_day }}</td>
                                <td>
                                    @if($leave->status == 1)
                                        <span class="badge badge-primary" style="font-size: 12px">{{ 'চলমান' }}</span>
                                    @elseif($leave->status == 2)
                                        <span class="badge badge-warning"  style="font-size: 12px">{{ 'ডাইরেক্টর অনুমোদিত' }}</span>
                                    @elseif($leave->status == 3)
                                        <span class="badge badge-success"  style="font-size: 12px">{{ 'অনুমোদন' }}</span>
                                    @elseif($leave->status == 4)
                                        <span class="badge badge-danger"  style="font-size: 12px">{{ 'বাতিল' }}</span>
                                    @endif
                                    </td>
                                <td>
                                    <div class='dropdown'>
                                        <button class='btn btn-outline-primary btn-xs dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                            ক্রিয়া
                                        </button>
                                        <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                            @if($leave->status != 0 || $leave->status != 2)
                                            {{-- <a href="{{ route('leaves.show', [$leave->leave_id]) }}" class='dropdown-item'><i class="im im-icon-Eye" data-placement="top" title="দেখুন"></i> দেখুন</a> --}}
                                            <a href="{{ route('leaves.edit', [$leave->id]) }}" class='dropdown-item'><i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="সম্পাদনা করুন"></i> সম্পাদনা করুন</a>
                                            <a href="{{ route('forward.to.md', $leave->leave_id) }}" class='dropdown-item'>
                                                <i class="im im-icon-Forward" data-toggle="tooltip" data-placement="top" title="প্রেরণ করুন"></i> প্রেরণ করুন
                                            </a>
                                            <a href="{{ route('leaves.approved', $leave->leave_id) }}" class='dropdown-item'>
                                                <i class="im im-icon-Check" data-toggle="tooltip" data-placement="top" title="অনুমোদন করুন"></i> অনুমোদন করুন
                                            </a>
                                            <a href="{{ route('leaves.rejected', $leave->leave_id) }}" class='dropdown-item'>
                                                <i class="im im-icon-Close" data-toggle="tooltip" data-placement="top" title="বাতিল করুন"></i> বাতিল করুন
                                            </a>

                                            {!! Form::open(['route' => ['leaves.destroy', $leave->leave_id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                                {!! Form::button('<i class="im im-icon-Remove" data-toggle="tooltip" data-placement="top" title="মুছে ফেলুন"></i> মুছে ফেলুন', ['type' => 'submit', 'class' => 'dropdown-item', 'onclick' => "return confirm('আপনি কি নিশ্চিত?')"]) !!}
                                            {!! Form::close() !!}

                                        @endif

                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endif


                            @if( Auth::user()->user_role == 5 && $leave->status == 2)
                            <tr>
                                <td>{{ $leave->id }}</td>
                                <td>{{ $leave->name_bn }}</td>
                                <td>{{ date('d M Y', strtotime($leave->from_date)) }}</td>
                                <td>{{ date('d M Y', strtotime($leave->to_date)) }}</td>
                                <td>{{ date('d M Y', strtotime($leave->approved_from_date)) }}</td>
                                <td>{{ date('d M Y', strtotime($leave->approved_to_date)) }}</td>
                                <td>{{ $leave->approved_total_day }}</td>
                                <td>
                                    @if($leave->status == 1)
                                        <span class="badge badge-primary" style="font-size: 12px">{{ 'চলমান' }}</span>
                                    @elseif($leave->status == 2)
                                        <span class="badge badge-primary"  style="font-size: 12px">{{ 'ডাইরেক্টর অনুমোদিত' }}</span>
                                    @elseif($leave->status == 3)
                                        <span class="badge badge-success"  style="font-size: 12px">{{ 'অনুমোদন' }}</span>
                                    @elseif($leave->status == 4)
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
                                            <a href="{{ route('leaves.approved', $leave->id) }}" class='dropdown-item'>
                                                <i class="im im-icon-Check" data-toggle="tooltip" data-placement="top" title="অনুমোদন করুন"></i> অনুমোদন করুন
                                            </a>
                                            <a href="{{ route('leaves.rejected', $leave->id) }}" class='dropdown-item'>
                                                <i class="im im-icon-Close" data-toggle="tooltip" data-placement="top" title="বাতিল করুন"></i> বাতিল করুন
                                            </a>
                                            {!! Form::open(['route' => ['leaves.destroy', $leave->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                                {!! Form::button('<i class="im im-icon-Remove" data-toggle="tooltip" data-placement="top" title="মুছে ফেলুন"></i> মুছে ফেলুন', ['type' => 'submit', 'class' => 'dropdown-item', 'onclick' => "return confirm('আপনি কি নিশ্চিত?')"]) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
