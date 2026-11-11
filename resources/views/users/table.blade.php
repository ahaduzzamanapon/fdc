




<div class="table-responsive">
    <table class="table table_data" id="users-table">
        <thead>
            <tr>
                <th>{{ __('messages.sl_label') }}</th>
                <th>{{ __('messages.name') }}</th>
                <th>{{ __('messages.username') }}</th>
                <th>{{ __('messages.group') }}</th>
                <th>{{ __('messages.email') }}</th>
                <th>{{ __('messages.status') }}</th>
                <th class="text-center">{{ __('messages.action') }}</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $key => $user)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $user->name_bn }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->current_status == 'Active')
                        <span class="badge badge-success">{{ __('messages.active') }}</span>
                    @else
                        <span class="badge badge-danger">{{ __('messages.inactive') }}</span>
                    @endif
                </td>
                <td class="text-center">
                    <div class="dropdown">
                        <button class="btn btn-outline-primary btn-xs dropdown-toggle" type="button" id="dropdownMenuButton{{ $user->id }}" data-bs-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ __('messages.actions_button') ?? 'অ্যাকশন' }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $user->id }}">
                            <a href="{{ route('users.show', [secure_hash_id($user->id)]) }}" class="dropdown-item">
                                <i class="im im-icon-Eye me-1"></i> {{ __('messages.view') }}
                            </a>
                            <a href="{{ route('users.edit', [secure_hash_id($user->id)]) }}" class="dropdown-item">
                                <i class="im im-icon-Pen me-1"></i> {{ __('messages.edit') }}
                            </a>
                            <a href="{{ route('employeePromotions.timeline', $user->id) }}" class="dropdown-item">
                                <i class="im im-icon-Clock me-1"></i> টাইমলাইন
                            </a>
                            @if(can('user_delete'))
                                {!! Form::open(['route' => ['users.destroy', secure_hash_id($user->id)], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                    {!! Form::button('<i class="im im-icon-Remove me-1"></i> ' . __('messages.delete'), ['type' => 'submit', 'class' => 'dropdown-item text-danger', 'onclick' => "return confirm('" . __('messages.are_you_sure') . "')"]) !!}
                                {!! Form::close() !!}
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
