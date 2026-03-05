<div class="table-responsive">
    <form method="GET" action="{{ route('decadeFilmsPhotos.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-3">
                <select name="year" class="form-control select2">
                    <option value="">বছর নির্বাচন করুন</option>
                    @foreach($years as $y)
                        <option value="{{ $y }}" {{ ($year ?? '') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="চলচ্চিত্র খুঁজুন..." value="{{ $search ?? '' }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    <table class="table data_t" id="photoGallery-table">
        <thead>
            <tr>
                <th>#</th>
                <th>চলচ্চিত্র</th>
                <th>ধরন</th>
                <th>মুক্তির তারিখ</th>
                <th>ছবি</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($galleries as $gallery)
            <tr>
                <td>{{ $galleries->firstItem() + $loop->index }}.</td>
                <td>{{ $gallery->film_name }}</td>
                <td>{{ $gallery->type }}</td>
                <td>{{ function_exists('convertToBengaliDate') ? convertToBengaliDate($gallery->release_date) : $gallery->release_date }}</td>
                <td>
                    @if($gallery->image)
                        <img src="{{ asset('storage/'.$gallery->image) }}" alt="" style="width:80px;height:60px;object-fit:cover;">
                    @endif
                </td>
                <td>
                    <div class='btn-group'>
                        <a href="{{ route('decadeFilmsPhotos.show', $gallery->id) }}" class='btn btn-outline-primary btn-xs'>
                            <i class="im im-icon-Eye" title="View"></i>
                        </a>
                        <a href="{{ route('decadeFilmsPhotos.edit', $gallery->id) }}" class='btn btn-outline-primary btn-xs'>
                            <i class="im im-icon-Pen" title="Edit"></i>
                        </a>
                        {!! Form::open(['route' => ['decadeFilmsPhotos.destroy', $gallery->id], 'method' => 'delete']) !!}
                            {!! Form::button('<i class="im im-icon-Remove" title="Delete"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                        {!! Form::close() !!}
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mt-3">
        {{ $galleries->links() }}
    </div>
</div>
