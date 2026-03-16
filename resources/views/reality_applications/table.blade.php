<div class="table-responsive">
    <table class="table table_data" id="filmApplications-table">
        <thead>
            <tr>
                <th>{{ __('messages.sl_label') }}</th>
                <th>{{ __('messages.title') }}</th>
                <th>{{ __('messages.applicant_name_label') }}</th>
                <th>{{ __('messages.organization_name') }}</th>
                <th>{{ __('messages.status') }}</th>
                <th>{{ __('messages.desk_label') }}</th>
                <th>{{ __('messages.action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($filmApplications as $key => $film)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $film->film_title }}</td>
                    <td>{{ $film->applicant_name }}</td>
                    <td>{{ $film->organization_name }}</td>
                    <td>{{ ucfirst($film->status) }}</td>
                    <td>{{ isset(get_role($film->desk_id)->name) ? Str::ucfirst(get_role($film->desk_id)->name) : '' }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-outline-primary btn-xs dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('messages.actions_button') }} </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a href="{{ route('realityApplications.show', [$film->id]) }}" class="dropdown-item"><i
                                        class="im im-icon-Eye" data-placement="top"
                                        title="{{ __('messages.view_label') }}"></i> {{ __('messages.view_label') }}</a>

                                {{--For draft edit--}}
                                @if($film->status == 'draft')
                                    <a href="{{ route('realityApplications.reality.edit.draft', [Crypt::encrypt($film->id)]) }}"
                                        class="dropdown-item"><i class="im im-icon-Pen" data-placement="top"
                                            title="{{ __('messages.edit_draft_button') }}"></i>
                                        {{ __('messages.edit_draft_button') }}</a>
                                @endif

                                @if ($film->status == 'on process' && !Auth::guard('producer')->check())
                                    <a href="{{ route('realityApplications.forward', [$film->id, 'additional_director_finance']) }}"
                                        class="dropdown-item"> <i class="im im-icon-Pen" data-toggle="tooltip"
                                            data-placement="top"
                                            title="{{ __('messages.check_and_forward') }}"></i>{{ __('messages.check_and_forward') }}</a>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
