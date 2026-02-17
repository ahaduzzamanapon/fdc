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
                            @if(Auth::user()->user_role == 5)
                            <th>সম্পাদনায়</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1; @endphp
                        @if(Auth::user()->user_role == 5)
                            @foreach($leave_md as $key => $leave_md)    
                                @if ( $leave_md->dpt_head_id != null && ($leave_md->status != 0 || $leave_md->status != 2 || $leave_md->status != 1 ))
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $leave_md->name_bn }}</td>
                                        <td>{{ date('d M Y', strtotime($leave_md->from_date)) }}</td>
                                        <td>{{ date('d M Y', strtotime($leave_md->to_date)) }}</td>
                                        <td>{{ date('d M Y', strtotime($leave_md->approved_from_date)) }}</td>
                                        <td>{{ date('d M Y', strtotime($leave_md->approved_to_date)) }}</td>
                                        <td>{{ $leave_md->approved_total_day }}</td>
                                        <td>
                                            @if($leave_md->status == 1)
                                                <span class="badge badge-primary" style="font-size: 12px">{{ 'চলমান' }}</span>
                                            @elseif($leave_md->status == 2)
                                                <span class="badge badge-primary"  style="font-size: 12px">{{ 'ডাইরেক্টর অনুমোদিত' }}</span>
                                            @elseif($leave_md->status == 3)
                                                <span class="badge badge-success"  style="font-size: 12px">{{ 'অনুমোদন' }}</span>
                                            @elseif($leave_md->status == 4)
                                                <span class="badge badge-danger"  style="font-size: 12px">{{ 'বাতিল' }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{   $leave_md->user_name }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            @foreach($leaves as $key => $leave)
                                @if (($leave->department == Auth::user()->department && $leave->dpt_head_id == Auth::user()->id) &&  ( $leave->status != 0 || $leave->status == 2 ))
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
                                                <span class="badge badge-primary"  style="font-size: 12px">{{ 'ডাইরেক্টর অনুমোদিত' }}</span>
                                            @elseif($leave->status == 3)
                                                <span class="badge badge-success"  style="font-size: 12px">{{ 'অনুমোদন' }}</span>
                                            @elseif($leave->status == 4)
                                                <span class="badge badge-danger"  style="font-size: 12px">{{ 'বাতিল' }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
