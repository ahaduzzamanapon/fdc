@extends('layouts.default')

@section('content')
    <section class="content-header">
    </section>

    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')
        <div class="clearfix"></div>

        <div class="card">
            <section class="card-header">
                <h5 class="card-title d-inline">চলচ্চিত্র সম্পর্কিত</h5>
                <span class="float-right">
                    <a class="btn btn-primary pull-right" href="{{ route('film_related.create') }}"> যোগ করুন </a>
                </span>
            </section>

            <div class="card-body table-responsive">
                <table class="table table_data" id="film_related-table">
                    <thead>
                        <tr>
                            <th> শিরোনাম </th>
                            <th> বিবরণ </th>
                            <th> একশন </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($film_related as $filmRelated)
                            <tr>
                                <td>{{ $filmRelated->title }}</td>
                                <td>{!! Str::limit(strip_tags($filmRelated->description), 50) !!}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary btn-xs dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            একশন </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a href="{{ route('film_related.edit', [$filmRelated->id]) }}"
                                                class="dropdown-item">
                                                <i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top"
                                                    title="Edit"></i> সম্পাদনা করুন
                                            </a>
                                            {!! Form::open(['route' => ['film_related.destroy', $filmRelated->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                            {!! Form::button('<i class="im im-icon-Remove" data-toggle="tooltip" data-placement="top" title="Delete"></i> মুছুন ', ['type' => 'submit', 'class' => 'dropdown-item', 'onclick' => "return confirm('আপনি কি নিশ্চিত?')"]) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
