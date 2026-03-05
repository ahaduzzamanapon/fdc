<div class="table-responsive">
    <!-- search form (POST) -->
    <form id="searchForm" method="POST" action="{{ route('decadeFilms.search') }}">
        @csrf
        <div class="row mb-3">
            <div class="col-md-3">
                <select id="year" name="year" class="form-control select2">
                    <option value="">বছর নির্বাচন করুন</option>
                    @foreach($years as $y)
                        <option value="{{ $y }}" {{ ($year ?? '') == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <input type="text" id="search" name="search" class="form-control"
                    placeholder="চলচ্চিত্র খুঁজুন..." value="{{ $search ?? '' }}">
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    <table class="table data_t" id="siteSettings-table">
        <thead>
            <tr>
                <th>#</th>
                <th>চলচ্চিত্র</th>
                <th>মুক্তির তারিখ</th>
                <th>পরিচালক</th>
                <th>অভিনয়ে</th>
                <th>প্রযোজক</th>
                <th>ধরন</th>
                <th>অর্জন</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($decadeFilmLists as $decadeFilmList)
            <tr>
            <td style="font-family:SutonnyMJ;font-size:16px">{{ $decadeFilmLists->firstItem() + $loop->index }}.</td>
                <td>{{ $decadeFilmList->film_name }}</td>
                <td>{{ convertToBengaliDate($decadeFilmList->release_date) }}</td>
                <td>{{ $decadeFilmList->producer_name }}</td>
                <td>{{ $decadeFilmList->acting }}</td>
                <td>{{ $decadeFilmList->type }}</td>
                <td>{{ $decadeFilmList->director_name }}</td>
                <td>{{ $decadeFilmList->achivements }}</td>
                <td>
                    <div class='btn-group'>
                        <a href="{{ route('decadeFilms.show', [$decadeFilmList->id]) }}" class='btn btn-outline-primary btn-xs'>
                            <i class="im im-icon-Eye" data-placement="top" title="{{ __('messages.view') }}"></i>
                        </a>
                        <a href="{{ route('decadeFilms.edit', [$decadeFilmList->id]) }}" class='btn btn-outline-primary btn-xs'>
                            <i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="{{ __('messages.edit') }}"></i>
                        </a>
                        {!! Form::open(['route' => ['decadeFilms.destroy', $decadeFilmList->id], 'method' => 'delete']) !!}
                            {!! Form::button('<i class="im im-icon-Remove" data-toggle="tooltip" data-placement="top" title="' . __('messages.delete') . '"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-xs', 'onclick' => "return confirm('" . __('messages.are_you_sure') . "')"]) !!}
                        {!! Form::close() !!}
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mt-3">
        {{ $decadeFilmLists->links() }}
    </div>
</div>

<!-- AJAX-based filtering removed; form submission will reload page with results -->

