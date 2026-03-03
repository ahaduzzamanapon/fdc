<div class="table-responsive">
    <table class="table table_data" id="filmApplications-table">
        <thead>
            <tr>
                <th>{{ __('messages.sl_label') }}</th>
                <th>{{ __('messages.film_title_label') }}</th>
                <th>{{ __('messages.applicant_name_label') }}</th>
                <th>{{ __('messages.organization_name')}}</th>
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
                                <a href="{{ route('filmApplications.show', [$film->id]) }}" class="dropdown-item"><i
                                        class="im im-icon-Eye" data-placement="top"
                                        title="{{ __('messages.view_label') }}"></i> {{ __('messages.view_label') }}</a>

                                {{--For draft edit--}}
                                @if($film->status == 'draft')
                                    <a href="{{ route('filmApplications.film.edit.draft', [Crypt::encrypt($film->id)]) }}"
                                        class="dropdown-item"><i class="im im-icon-Pen" data-placement="top"
                                            title="{{ __('messages.edit_draft_button') }}"></i>
                                        {{ __('messages.edit_draft_button') }}</a>
                                @endif

                                @if ($film->status == 'on process' && !Auth::guard('producer')->check())
                                    <a href="{{ route('filmApplications.forward', [$film->id, 'additional_director_finance']) }}"
                                        class="dropdown-item"> <i class="im im-icon-Pen" data-toggle="tooltip"
                                            data-placement="top"
                                            title="{{ __('messages.check_and_forward') }}"></i>{{ __('messages.check_and_forward') }}</a>
                                @endif


                                {{-- old code --}}
                                @if ($film->state == 'forward' && $film->desk == 'additional_director_finance' && can('additional_director_finance'))
                                    <a href="{{ route('filmApplications.forward', [$film->id, 'assistant_director_admin']) }}"
                                        class="dropdown-item">
                                        <i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top"
                                            title="{{ __('messages.check_and_forward') }}"></i>Forward to Assistant Director
                                        Admin</a>
                                @endif

                                @if ($film->state == 'forward' && $film->desk == 'assistant_director_admin' && can('assistant_director_admin'))
                                    <a href="{{ route('filmApplications.forward', [$film->id, 'assistant_production']) }}"
                                        class="dropdown-item">
                                        <i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top"
                                            title="{{ __('messages.check_and_forward') }}"></i>Forward to Assistant
                                        Production</a>
                                @endif

                                @if ($film->state == 'back' && $film->desk == 'assistant_production' && can('assistant_production'))
                                    <a href="{{ route('filmApplications.back', [$film->id, 'assistant_director_admin']) }}"
                                        class="dropdown-item"><i class="im im-icon-Pen" data-toggle="tooltip"
                                            data-placement="top" title="{{ __('messages.check_and_forward') }}"></i>Back to
                                        Assistant Director Admin</a>
                                @endif

                                @if ($film->state == 'back' && $film->desk == 'assistant_director_admin' && can('assistant_director_admin'))
                                    <a href="{{ route('filmApplications.back', [$film->id, 'additional_director_finance']) }}"
                                        class="dropdown-item"><i class="im im-icon-Pen" data-toggle="tooltip"
                                            data-placement="top" title="{{ __('messages.check_and_forward') }}"></i>Back to
                                        Additional Director Finance</a>
                                @endif


                                @if ($film->state == 'back' && $film->desk == 'additional_director_finance' && can('additional_director_finance'))
                                    <a href="{{ route('filmApplications.back', [$film->id, 'director_production']) }}"
                                        class="dropdown-item"><i class="im im-icon-Pen" data-toggle="tooltip"
                                            data-placement="top" title="{{ __('messages.check_and_forward') }}"></i>Back to
                                        Director Production</a>
                                @endif

                                @if ($film->state == 'back' && $film->desk == 'director_production' && can('director_production'))
                                    <a href="{{ route('filmApplications.final_forward_to_md', [$film->id, 'md']) }}"
                                        class="dropdown-item"><i class="im im-icon-Pen" data-toggle="tooltip"
                                            data-placement="top" title="{{ __('messages.check_and_forward') }}"></i> Forward to
                                        MD</a>
                                @endif

                                @if ($film->state == 'back' && $film->desk == 'All Desks Completed Waiting for MD Approval' && can('md'))
                                    <a href="{{ route('filmApplications.approve_md', [$film->id, 'md']) }}"
                                        class="dropdown-item"><i class="im im-icon-Pen" data-toggle="tooltip"
                                            data-placement="top" title="{{ __('messages.approve') }}"></i>
                                        {{ __('messages.approve') }}</a>
                                @endif



                                @if ($film->state == 'back' && $film->desk == 'MD Approved')
                                    <a class="dropdown-item cursor-pointer" onclick="showMakePaymentModal({{ $film->id }})"><i
                                            class="im im-icon-Pen" data-toggle="tooltip" data-placement="top"
                                            title="{{ __('messages.make_payment') }}"></i> {{ __('messages.make_payment') }}</a>
                                    <a href="{{ route('filmApplications.payment_data', [$film->id]) }}" class="dropdown-item"><i
                                            class="im im-icon-Eye" data-toggle="tooltip" data-placement="top"
                                            title="{{ __('messages.payment_data') }}"></i> {{ __('messages.payment_data') }}</a>
                                @endif


                                @if ($film->state == 'forward' && $film->desk == 'director_production')
                                    <a href="{{ route('filmApplications.edit', [$film->id]) }}" class="dropdown-item"><i
                                            class="im im-icon-Pen" data-toggle="tooltip" data-placement="top"
                                            title="{{ __('messages.edit') }}"></i> {{ __('messages.edit') }}</a>
                                    {!! Form::open(['route' => ['filmApplications.destroy', $film->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                    {!! Form::button('<i class="im im-icon-Remove" data-toggle="tooltip" data-placement="top" title="' . __('messages.delete_button') . '"></i> ' . __('messages.delete_button'), ['type' => 'submit', 'class' => 'dropdown-item', 'onclick' => "return confirm('" . __('messages.are_you_sure') . "')"]) !!}
                                    {!! Form::close() !!}
                                @endif

                                {{-- old code end --}}
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>