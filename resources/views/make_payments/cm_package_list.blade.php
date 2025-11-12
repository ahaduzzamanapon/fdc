@extends('layouts.default')

{{-- Page title --}}
@section('title')
কাস্টম প্যাকেজ @parent
@stop

<style>
  .checkbox-wrapper-20 *,
    .checkbox-wrapper-20 *:after,
    .checkbox-wrapper-20 *:before {
    box-sizing: border-box;
  }
  .checkbox-wrapper-20 .checkbox-wrapper {
    width: 100%;
  }

  .checkbox-wrapper-20 .checkbox-input {
    clip: rect(0 0 0 0);
    -webkit-clip-path: inset(100%);
    clip-path: inset(100%);
    height: 1px;
    overflow: hidden;
    position: absolute;
    white-space: nowrap;
    width: 1px;
  }

  .checkbox-wrapper-20 .checkbox-input:checked + .checkbox-tile {
    border-color: #2260ff;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    color: #2260ff;
  }

  .checkbox-wrapper-20 .checkbox-input:checked + .checkbox-tile .checkbox-icon,
    .checkbox-wrapper-20 .checkbox-input:checked + .checkbox-tile .checkbox-label {
    color: #2260ff;
  }

  .checkbox-wrapper-20 .checkbox-input:focus + .checkbox-tile {
    border-color: #2260ff;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1), 0 0 0 4px #b5c9fc;
  }

  .checkbox-wrapper-20 .checkbox-tile {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 7rem;
    min-height: 7rem;
    border-radius: 0.5rem;
    border: 2px solid #b5bfd9;
    background-color: #fff;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    transition: 0.15s ease;
    cursor: pointer;
    position: relative;
    width: 100%;
  }

  .checkbox-wrapper-20 .checkbox-tile:hover {
    border-color: #2260ff;
  }

  .checkbox-wrapper-20 .checkbox-icon {
    transition: 0.375s ease;
    color: #494949;
  }

  .checkbox-wrapper-20 .checkbox-icon svg {
    width: 3rem;
    height: 3rem;
  }

  .checkbox-wrapper-20 .checkbox-label {
    color: #707070;
    transition: 0.375s ease;
    text-align: center;
  }

</style>

@section('content')
<!-- Content Header (Page header) -->
<!-- Main content -->
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="card" width="88vw;">
            <section class="card-header">
                <h5 class="card-title d-inline">কাস্টম প্যাকেজ </h5>
                <span class="float-right">
                  <a class="btn btn-primary pull-right" href="{{ route('makePayments.makeCustomPackage') }}" >{{ __('messages.add_new') }}</a>
              </span>
            </section>

            <div class="card-body">
              <div class="table-responsive">
                  <table class="table table-bordered table-striped table-hover">
                      <thead class="text-white" style="background-color: #8dc542;">
                          <tr>
                              <th>{{ 'নং' }}</th>
                              <th>{{ 'নাম' }}</th>
                              <th>{{ __('messages.amount') }}</th>
                              <th>{{ 'অবস্থা' }}</th>
                              <th>{{ '​পর্যালোচনা' }}</th>
                              <th>{{ 'তারিখ' }}</th>
                              <th>{{ 'কার্যক্রম' }}</th>
                          </tr>
                      </thead>
                      <tbody>
                          @forelse($filmPackage as $key => $payment)
                          <tr>
                              <td>{{ ++$key ?? 'N/A' }}</td>
                              <td>{{ $payment->name ?? 'N/A' }}</td>
                              <td>{{ $payment->amount ?? 'N/A' }}</td>
                              <td><span class="badge text-white" style="background-color: #8dc542;">{{ $payment->status ?? 'N/A' }}</span></td>
                              <td><span class="badge text-white" style="background-color: #8dc542;">{{ $payment->review_status ?? 'N/A' }}</span></td>
                              <td>{{ $payment->updated_at ? $payment->updated_at->format('M d, Y H:i A') : 'N/A' }}</td>
                              <td>
                                  <div class="dropdown">
                                      <button class="btn btn-outline-primary btn-xs dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Actions </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                          <a target="_blank" href="{{ route('filmApplications.single_payment_receipt', $payment->id) }}" class="btn btn-sm text-white" style="background-color: #8dc542; border-color: #8dc542;">{{ 'পেমেন্ট স্লিপ' }}</a>

                                          @if ($payment->review_status == 'on process' && !Auth::guard('producer')->check())
                                              <a href="{{ route('makePayments.forward', [$payment->id, 'additional_director_finance']) }}" class="dropdown-item"> <i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="Forward to Additional Director(Sales)"></i>Check And Forward</a>
                                          @endif
                                      </div>
                                  </div>

                              </td>
                          </tr>
                          @empty
                          <tr>
                              <td colspan="7" class="text-center">{{ 'কোনও পেমেন্ট রেকর্ড পাওয়া যায়নি' }}</td>
                          </tr>
                          @endforelse
                      </tbody>
                  </table>
              </div>
            </div>
        </div>
    </div>

@endsection


