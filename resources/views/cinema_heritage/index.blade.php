@extends('layouts.default')

@section('content')
<style>
    .page-title-text {
        font-size: 18px !important;
        font-weight: 700 !important;
        color: #1e293b !important;
        margin: 0;
    }
    .heritage-tab-bar {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 8px 12px;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        min-height: 0 !important;
        height: auto !important;
    }
    .custom-heritage-tabs {
        display: flex;
        gap: 10px;
        padding: 0;
        flex-wrap: wrap;
        border-bottom: 0 !important;
        margin: 0;
    }
    .custom-heritage-tabs .nav-link {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        border-radius: 6px !important;
        padding: 7px 15px;
        transition: all 0.2s ease-in-out;
        background-color: #f1f5f9;
        border: 1px solid #cbd5e1;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }
    .custom-heritage-tabs .nav-link:hover {
        background-color: #e2e8f0;
        color: #0f172a;
    }
    .custom-heritage-tabs .nav-link.active {
        background-color: #28a745 !important;
        background: #28a745 !important;
        color: #ffffff !important;
        border-color: #28a745 !important;
        box-shadow: 0 3px 8px rgba(40, 167, 69, 0.3);
    }
    .item-count-badge {
        background-color: rgba(255, 255, 255, 0.3);
        color: #fff;
        font-size: 11px;
        padding: 1px 7px;
        border-radius: 12px;
        margin-left: 4px;
    }
    .custom-heritage-tabs .nav-link:not(.active) .item-count-badge {
        background-color: #cbd5e1;
        color: #334155;
    }
    .inner-heritage-tabs {
        border-bottom: 0 !important;
        gap: 8px;
        margin: 0;
        padding: 0;
    }
    .inner-heritage-tabs .nav-link {
        font-size: 13.5px;
        font-weight: 600;
        color: #475569;
        border-radius: 6px !important;
        padding: 8px 16px;
        transition: all 0.2s ease;
        background-color: #f1f5f9;
        border: 1px solid #cbd5e1;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .inner-heritage-tabs .nav-link:hover {
        background-color: #e2e8f0;
        color: #0f172a;
    }
    .inner-heritage-tabs .nav-link.active {
        background-color: #0d6efd !important;
        background: #0d6efd !important;
        color: #ffffff !important;
        border-color: #0d6efd !important;
        box-shadow: 0 3px 8px rgba(13, 110, 253, 0.3);
    }
    .subtab-badge {
        background-color: rgba(255, 255, 255, 0.3);
        color: #fff;
        font-size: 11px;
        padding: 1px 7px;
        border-radius: 12px;
        margin-left: 4px;
    }
    .inner-heritage-tabs .nav-link:not(.active) .subtab-badge {
        background-color: #cbd5e1;
        color: #334155;
    }
</style>

    <section class="content-header py-2 mb-2">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-8">
                    <h5 class="page-title-text">
                        <i class="im im-icon-File"></i> চলচ্চিত্রের ইতিহাস ও ঐতিহ্য পেজ ম্যানেজমেন্ট
                    </h5>
                </div>
            </div>
        </div>
    </section>

    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')
        <div class="clearfix"></div>

        <div class="heritage-tab-bar mb-3">
            <ul class="nav custom-heritage-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ $currentSlug == 'classic_films' ? 'active' : '' }}" href="{{ route('cinema_heritage.index', ['page' => 'classic_films']) }}">
                        <i class="im im-icon-Film"></i> কালজয়ী বাংলা চলচ্চিত্র
                        @if(isset($pages['classic_films']))
                            <span class="item-count-badge">{{ count($pages['classic_films']->items) }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $currentSlug == 'top_grossing_films' ? 'active' : '' }}" href="{{ route('cinema_heritage.index', ['page' => 'top_grossing_films']) }}">
                        <i class="im im-icon-Line-Chart"></i> বছরভিত্তিক সর্বোচ্চ ব্যবসাসফল সিনেমা
                        @if(isset($pages['top_grossing_films']))
                            <span class="item-count-badge">{{ count($pages['top_grossing_films']->items) }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $currentSlug == 'national_film_awards' ? 'active' : '' }}" href="{{ route('cinema_heritage.index', ['page' => 'national_film_awards']) }}">
                        <i class="im im-icon-Trophy"></i> জাতীয় চলচ্চিত্র পুরস্কার
                        @if(isset($pages['national_film_awards']))
                            <span class="item-count-badge">{{ count($pages['national_film_awards']->items) }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $currentSlug == 'international_films' ? 'active' : '' }}" href="{{ route('cinema_heritage.index', ['page' => 'international_films']) }}">
                        <i class="im im-icon-Globe"></i> আন্তর্জাতিক পর্যায়ে বাংলা চলচ্চিত্র
                        @if(isset($pages['international_films']))
                            <span class="item-count-badge">{{ count($pages['international_films']->items) }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>

        <!-- SINGLE CARD WITH 2 INNER SUB-TABS -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white p-2 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                <ul class="nav inner-heritage-tabs" id="heritageSubTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $subTab == 'info' ? 'active' : '' }}" id="info-subtab" href="#infoSubTab" data-bs-toggle="tab" data-toggle="tab" role="tab" aria-controls="infoSubTab" aria-selected="{{ $subTab == 'info' ? 'true' : 'false' }}">
                            <i class="im im-icon-Pen"></i> "{{ $currentPage->title }}" - পেজ তথ্য সম্পাদনা
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $subTab == 'items' ? 'active' : '' }}" id="items-subtab" href="#itemsSubTab" data-bs-toggle="tab" data-toggle="tab" role="tab" aria-controls="itemsSubTab" aria-selected="{{ $subTab == 'items' ? 'true' : 'false' }}">
                            <i class="im im-icon-List"></i> "{{ $currentPage->title }}" - চলচ্চিত্র / পুরস্কার তালিকা <span class="subtab-badge">{{ count($items) }}</span>
                        </a>
                    </li>
                </ul>

                <button type="button" class="btn btn-success btn-sm ms-auto my-1" data-bs-toggle="modal" data-bs-target="#addItemModal" data-toggle="modal" data-target="#addItemModal">
                    <i class="im im-icon-Plus"></i> নতুন তথ্য/মুভি যোগ করুন
                </button>
            </div>

            <div class="card-body">
                <div class="tab-content" id="heritageSubTabsContent">
                    <!-- SUB-TAB 1: PAGE INFO EDIT -->
                    <div class="tab-pane fade {{ $subTab == 'info' ? 'show active' : '' }}" id="infoSubTab" role="tabpanel" aria-labelledby="info-subtab">
                        <form action="{{ route('cinema_heritage.updatePage', $currentPage->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label class="font-weight-bold">পেজ শিরোনাম (Page Title):*</label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title', $currentPage->title) }}" required>
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label class="font-weight-bold">ব্যানার ইমেজ (Header Banner Image):</label>
                                    <input type="file" name="banner_image" class="form-control" accept="image/*">
                                    @if(!empty($currentPage->banner_image))
                                        <div class="mt-2">
                                            <img src="{{ \Illuminate\Support\Str::startsWith($currentPage->banner_image, 'http') ? $currentPage->banner_image : asset($currentPage->banner_image) }}" style="max-height: 80px;" class="img-thumbnail" alt="">
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-12 form-group mb-3">
                                    <label class="font-weight-bold">ব্যানার সাবটাইটেল / সংক্ষিপ্ত বিবরণ:</label>
                                    <textarea name="banner_subtitle" rows="2" class="form-control">{{ old('banner_subtitle', $currentPage->banner_subtitle) }}</textarea>
                                </div>
                                <div class="col-md-12 form-group mb-3">
                                    <label class="font-weight-bold">মেইন সেকশন বিস্তারিত বিবরণ:</label>
                                    <textarea name="main_description" rows="4" class="form-control">{{ old('main_description', $currentPage->main_description) }}</textarea>
                                </div>
                            </div>
                            <div class="text-right text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="im im-icon-Disk"></i> পেজ তথ্য সেভ করুন
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- SUB-TAB 2: ITEMS / CARDS LIST -->
                    <div class="tab-pane fade {{ $subTab == 'items' ? 'show active' : '' }}" id="itemsSubTab" role="tabpanel" aria-labelledby="items-subtab">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th style="width: 70px;">ক্রম</th>
                                        <th style="width: 80px;">ছবি</th>
                                        <th>শিরোনাম (Title)</th>
                                        <th>সাবটাইটেল (Director/Year/Info)</th>
                                        <th>বিবরণ (Description)</th>
                                        <th style="width: 150px;">একশন</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $item)
                                        <tr>
                                            <td>{{ $item->sort_order }}</td>
                                            <td>
                                                @if(!empty($item->image))
                                                    <img src="{{ \Illuminate\Support\Str::startsWith($item->image, 'http') ? $item->image : asset($item->image) }}" style="width: 50px; height: 50px; object-fit: cover;" class="rounded" alt="">
                                                @else
                                                    <span class="text-muted">No img</span>
                                                @endif
                                            </td>
                                            <td><strong>{{ $item->title }}</strong></td>
                                            <td>
                                                @if(!empty($item->sub_title))
                                                    <span class="badge bg-info text-dark">{{ $item->sub_title }}</span>
                                                @endif
                                            </td>
                                            <td>{!! Str::limit(e($item->description), 80) !!}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#editItemModal{{ $item->id }}" data-toggle="modal" data-target="#editItemModal{{ $item->id }}">
                                                    <i class="im im-icon-Pen"></i> সম্পাদনা
                                                </button>
                                                <form action="{{ route('cinema_heritage.destroyItem', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('আপনি কি নিশ্চিত এই তথ্যটি মুছতে চান?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="im im-icon-Remove"></i> মুছুন
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- EDIT ITEM MODAL -->
                                        <div class="modal fade" id="editItemModal{{ $item->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('cinema_heritage.updateItem', $item->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">তথ্য সম্পাদনা করুন</h5>
                                                            <button type="button" class="btn-close close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group mb-3">
                                                                <label class="font-weight-bold">শিরোনাম (Title):*</label>
                                                                <input type="text" name="title" class="form-control" value="{{ $item->title }}" required>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="font-weight-bold">সাবটাইটেল (যেমন: পরিচালক/বছর/ক্যাটাগরি):</label>
                                                                <input type="text" name="sub_title" class="form-control" value="{{ $item->sub_title }}">
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="font-weight-bold">বিবরণ (Description):</label>
                                                                <textarea name="description" rows="4" class="form-control">{{ $item->description }}</textarea>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="font-weight-bold">ছবি/পোস্টার (Image Upload):</label>
                                                                <input type="file" name="image" class="form-control" accept="image/*">
                                                                @if(!empty($item->image))
                                                                    <div class="mt-2">
                                                                        <img src="{{ \Illuminate\Support\Str::startsWith($item->image, 'http') ? $item->image : asset($item->image) }}" style="max-height: 80px;" class="img-thumbnail" alt="">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="font-weight-bold">ক্রম (Sort Order):</label>
                                                                <input type="number" name="sort_order" class="form-control" value="{{ $item->sort_order }}">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-dismiss="modal">বন্ধ করুন</button>
                                                            <button type="submit" class="btn btn-primary">আপডেট করুন</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">এই পেজে কোনো তথ্য/মুভি পাওয়া যায়নি।</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ADD ITEM MODAL -->
    <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('cinema_heritage.storeItem') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="page_id" value="{{ $currentPage->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title">নতুন তথ্য/মুভি যোগ করুন</h5>
                        <button type="button" class="btn-close close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">শিরোনাম (Title):*</label>
                            <input type="text" name="title" class="form-control" placeholder="যেমন: পথের পাঁচালী" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">সাবটাইটেল (যেমন: পরিচালক: সত্যজিৎ রায় | বছর: ১৯৫৫):</label>
                            <input type="text" name="sub_title" class="form-control" placeholder="পরিচালক: ... | বছর: ...">
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">বিবরণ (Description):</label>
                            <textarea name="description" rows="4" class="form-control" placeholder="বিবরণ লিখুন..."></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">ছবি/পোস্টার (Image Upload):</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">ক্রম (Sort Order):</label>
                            <input type="number" name="sort_order" class="form-control" value="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-dismiss="modal">বন্ধ করুন</button>
                        <button type="submit" class="btn btn-primary">সেভ করুন</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
