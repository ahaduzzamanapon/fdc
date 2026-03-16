<div class="table-responsive">
    <table class="table table_data" id="producers-table">
        <thead>
            <tr>
                <th>{{ __('messages.sl_label') }}</th>
                <th>{{ __('messages.organization_name') }}</th>
                <th>Name</th>
                <th>{{ __('messages.phone_number') }}</th>
                <th>{{ __('messages.email') }}</th>
                <th>{{ __('messages.status') }}</th>
                <th>{{ __('messages.action') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($producers as $key => $producer)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $producer->organization_name }}</td>
                <td>{{ $producer->owners_name }}</td>
                <td>{{ $producer->phone_number }}</td>
                <td>{{ $producer->email }}</td>
                @if ($producer->reg_status == 'pending')
                    <td class="text-danger"> অপেক্ষমাণ </td>
                @elseif ($producer->reg_status == 'verified')
                    <td class="text-success"> অনুমোদিত </td>
                @else
                    <td class="text-danger"> বাতিল </td>
                @endif

                <td>
                    <div class='dropdown'>
                        <button class='btn btn-outline-primary btn-xs dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            {{ __('messages.action_label') }}
                        </button>
                        <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                            <a class='dropdown-item' href="{{ route('producers.show', [$producer->id]) }}"><i class="im im-icon-Eye" data-placement="top" title="{{ __('messages.view') }}"></i> {{ __('messages.view_label') }}</a>
                            @if ($producer->reg_status == 'pending')
                                <a class='dropdown-item' href="{{ route('producer.registration.forward', [$producer->id]) }}"><i class="im im-icon-Eye" data-placement="top" title="approval"></i> Approval/Reject </a>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
