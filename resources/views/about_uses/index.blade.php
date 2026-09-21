@extends('layouts.default')

@section('content')
<style>
    .page-title-text {
        font-size: 18px !important;
        font-weight: 700 !important;
        color: #1e293b !important;
        margin: 0;
    }
    .custom-admin-tabs {
        display: flex;
        gap: 10px;
        padding: 4px;
        border-bottom: 0 !important;
    }
    .custom-admin-tabs .nav-link {
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        border-radius: 8px !important;
        padding: 9px 18px;
        transition: all 0.2s ease-in-out;
        background-color: #f1f5f9;
        border: 1px solid #cbd5e1;
    }
    .custom-admin-tabs .nav-link:hover {
        background-color: #e2e8f0;
        color: #0f172a;
    }
    .custom-admin-tabs .nav-link.active {
        background-color: #28a745 !important;
        background: #28a745 !important;
        color: #ffffff !important;
        border-color: #28a745 !important;
        box-shadow: 0 4px 10px rgba(40, 167, 69, 0.35);
    }
    .badge-count {
        background-color: rgba(255, 255, 255, 0.3);
        color: #fff;
        font-size: 11px;
        padding: 2px 7px;
        border-radius: 10px;
        margin-left: 6px;
    }
    .custom-admin-tabs .nav-link:not(.active) .badge-count {
        background-color: #cbd5e1;
        color: #334155;
    }
</style>

    <section class="content-header py-2 mb-2">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-8">
                    <h5 class="page-title-text">
                        <i class="im im-icon-File"></i> আমাদের সম্পর্কে পেজ ম্যানেজমেন্ট
                    </h5>
                </div>
            </div>
        </div>
    </section>

    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')
        <div class="clearfix"></div>

        @php
            $activeTab = request()->query('tab', request()->get('tab', 'main'));
        @endphp

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white p-2 border-bottom-0">
                <ul class="nav custom-admin-tabs" id="aboutUsTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $activeTab == 'main' ? 'active' : '' }}" id="main-tab" href="#mainTab" data-bs-toggle="tab" data-toggle="tab" role="tab" aria-controls="mainTab" aria-selected="{{ $activeTab == 'main' ? 'true' : 'false' }}">
                            <i class="im im-icon-File-Edit"></i> পেজ কন্টেন্ট ও ছবি
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $activeTab == 'features' ? 'active' : '' }}" id="features-tab" href="#featuresTab" data-bs-toggle="tab" data-toggle="tab" role="tab" aria-controls="featuresTab" aria-selected="{{ $activeTab == 'features' ? 'true' : 'false' }}">
                            <i class="im im-icon-Layout-3"></i> ইনফো কার্ড / ফিচার সমুহ <span class="badge-count">{{ count($features) }}</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $activeTab == 'officers' ? 'active' : '' }}" id="officers-tab" href="#officersTab" data-bs-toggle="tab" data-toggle="tab" role="tab" aria-controls="officersTab" aria-selected="{{ $activeTab == 'officers' ? 'true' : 'false' }}">
                            <i class="im im-icon-User"></i> কর্মকর্তাবৃন্দ <span class="badge-count">{{ count($officers) }}</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="aboutUsTabsContent">

                    <!-- TAB 1: MAIN PAGE CONTENT -->
                    <div class="tab-pane fade {{ $activeTab == 'main' ? 'show active' : '' }}" id="mainTab" role="tabpanel" aria-labelledby="main-tab">
                        <form action="{{ route('about_uses.updateMain') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label for="banner_title" class="font-weight-bold">ব্যানার হেডিং (H1):</label>
                                    <input type="text" name="banner_title" id="banner_title" class="form-control" value="{{ old('banner_title', $aboutUs->banner_title ?? '') }}" required>
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="main_title" class="font-weight-bold">মেইন সেকশন হেডিং:</label>
                                    <input type="text" name="main_title" id="main_title" class="form-control" value="{{ old('main_title', $aboutUs->main_title ?? '') }}" required>
                                </div>
                                <div class="col-md-12 form-group mb-3">
                                    <label for="banner_subtitle" class="font-weight-bold">ব্যানার সাবটাইটেল / বিবরণ:</label>
                                    <textarea name="banner_subtitle" id="banner_subtitle" rows="3" class="form-control">{{ old('banner_subtitle', $aboutUs->banner_subtitle ?? '') }}</textarea>
                                </div>
                                <div class="col-md-12 form-group mb-3">
                                    <label for="main_description" class="font-weight-bold">মেইন সেকশন বিস্তারিত বিবরণ:</label>
                                    <textarea name="main_description" id="main_description" rows="5" class="form-control">{{ old('main_description', $aboutUs->main_description ?? '') }}</textarea>
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="team_title" class="font-weight-bold">কর্মকর্তাদের সেকশন শিরোনাম:</label>
                                    <input type="text" name="team_title" id="team_title" class="form-control" value="{{ old('team_title', $aboutUs->team_title ?? 'কর্মকর্তাবৃন্দ') }}">
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="main_image" class="font-weight-bold">মেইন ছবি (Image Upload):</label>
                                    <input type="file" name="main_image" id="main_image" class="form-control" accept="image/*">
                                    @if(!empty($aboutUs->main_image))
                                        <div class="mt-2">
                                            <img src="{{ \Illuminate\Support\Str::startsWith($aboutUs->main_image, 'http') ? $aboutUs->main_image : asset($aboutUs->main_image) }}" style="max-height: 100px;" class="img-thumbnail" alt="Main Image">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="text-end text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="im im-icon-Disk"></i> পরিবর্তন সেভ করুন
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- TAB 2: FEATURE CARDS -->
                    <div class="tab-pane fade {{ $activeTab == 'features' ? 'show active' : '' }}" id="featuresTab" role="tabpanel" aria-labelledby="features-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>ইনফো কার্ড / ফিচার তালিকা</h5>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addFeatureModal" data-toggle="modal" data-target="#addFeatureModal">
                                <i class="im im-icon-Plus"></i> নতুন ফিচার যোগ করুন
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 80px;">ক্রম</th>
                                        <th>শিরোনাম</th>
                                        <th>আইটেম সমূহ (বুলেট পয়েন্ট)</th>
                                        <th style="width: 150px;">একশন</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($features as $feature)
                                        <tr>
                                            <td>{{ $feature->sort_order }}</td>
                                            <td><strong>{{ $feature->title }}</strong></td>
                                            <td>
                                                @if(!empty($feature->items))
                                                    <ul class="mb-0 pl-3">
                                                        @foreach(array_filter(explode("\n", str_replace("\r", "", $feature->items))) as $item)
                                                            <li>{{ trim($item) }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#editFeatureModal{{ $feature->id }}" data-toggle="modal" data-target="#editFeatureModal{{ $feature->id }}">
                                                    <i class="im im-icon-Pen"></i> সম্পাদনা
                                                </button>
                                                <form action="{{ route('about_uses.destroyFeature', $feature->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('আপনি কি নিশ্চিত এই ফিচারটি মুছতে চান?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="im im-icon-Remove"></i> মুছুন
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- EDIT FEATURE MODAL -->
                                        <div class="modal fade" id="editFeatureModal{{ $feature->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('about_uses.updateFeature', $feature->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">ফিচার সম্পাদনা করুন</h5>
                                                            <button type="button" class="btn-close close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group mb-3">
                                                                <label class="font-weight-bold">শিরোনাম:*</label>
                                                                <input type="text" name="title" class="form-control" value="{{ $feature->title }}" required>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="font-weight-bold">আইটেম সমূহ (প্রতি লাইনে একটি করে আইটেম লিখুন):</label>
                                                                <textarea name="items" rows="5" class="form-control">{{ $feature->items }}</textarea>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="font-weight-bold">ক্রম (Sort Order):</label>
                                                                <input type="number" name="sort_order" class="form-control" value="{{ $feature->sort_order }}">
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
                                            <td colspan="4" class="text-center text-muted">কোনো ফিচার তথ্য পাওয়া যায়নি।</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- TAB 3: OFFICERS -->
                    <div class="tab-pane fade {{ $activeTab == 'officers' ? 'show active' : '' }}" id="officersTab" role="tabpanel" aria-labelledby="officers-tab">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5>কর্মকর্তাবৃন্দ তালিকা</h5>
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addOfficerModal" data-toggle="modal" data-target="#addOfficerModal">
                                <i class="im im-icon-User-Add"></i> নতুন কর্মকর্তা যোগ করুন
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 80px;">ক্রম</th>
                                        <th style="width: 80px;">ছবি</th>
                                        <th>নাম</th>
                                        <th>পদবী / অফিস</th>
                                        <th style="width: 150px;">একশন</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($officers as $officer)
                                        <tr>
                                            <td>{{ $officer->sort_order }}</td>
                                            <td>
                                                @if(!empty($officer->image))
                                                    <img src="{{ \Illuminate\Support\Str::startsWith($officer->image, 'http') ? $officer->image : asset($officer->image) }}" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;" alt="{{ $officer->name }}">
                                                @else
                                                    <span class="text-muted">No image</span>
                                                @endif
                                            </td>
                                            <td><strong>{{ $officer->name }}</strong></td>
                                            <td>{{ $officer->designation }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#editOfficerModal{{ $officer->id }}" data-toggle="modal" data-target="#editOfficerModal{{ $officer->id }}">
                                                    <i class="im im-icon-Pen"></i> সম্পাদনা
                                                </button>
                                                <form action="{{ route('about_uses.destroyOfficer', $officer->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('আপনি কি নিশ্চিত এই কর্মকর্তা তথ্যটি মুছতে চান?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="im im-icon-Remove"></i> মুছুন
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- EDIT OFFICER MODAL -->
                                        <div class="modal fade" id="editOfficerModal{{ $officer->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('about_uses.updateOfficer', $officer->id) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">কর্মকর্তার তথ্য সম্পাদনা করুন</h5>
                                                            <button type="button" class="btn-close close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group mb-3">
                                                                <label class="font-weight-bold">নাম:*</label>
                                                                <input type="text" name="name" class="form-control" value="{{ $officer->name }}" required>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="font-weight-bold">পদবী / দপ্তর:</label>
                                                                <input type="text" name="designation" class="form-control" value="{{ $officer->designation }}">
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="font-weight-bold">ছবি (Photo Upload):</label>
                                                                <input type="file" name="image" class="form-control" accept="image/*">
                                                                @if(!empty($officer->image))
                                                                    <div class="mt-2">
                                                                        <img src="{{ \Illuminate\Support\Str::startsWith($officer->image, 'http') ? $officer->image : asset($officer->image) }}" style="max-height: 80px;" class="img-thumbnail" alt="">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="font-weight-bold">ক্রম (Sort Order):</label>
                                                                <input type="number" name="sort_order" class="form-control" value="{{ $officer->sort_order }}">
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
                                            <td colspan="5" class="text-center text-muted">কোনো কর্মকর্তা তথ্য পাওয়া যায়নি।</td>
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

    <!-- ADD FEATURE MODAL -->
    <div class="modal fade" id="addFeatureModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('about_uses.storeFeature') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">নতুন ফিচার যোগ করুন</h5>
                        <button type="button" class="btn-close close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">শিরোনাম:*</label>
                            <input type="text" name="title" class="form-control" placeholder="যেমন: এফডিসি" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">আইটেম সমূহ (প্রতি লাইনে একটি করে আইটেম লিখুন):</label>
                            <textarea name="items" rows="5" class="form-control" placeholder="বিএফডিসি সাংগঠনিক কাঠামো&#10;মুক্তি প্রাপ্ত বাংলা চলচ্চিত্রের তালিকা"></textarea>
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

    <!-- ADD OFFICER MODAL -->
    <div class="modal fade" id="addOfficerModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('about_uses.storeOfficer') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">নতুন কর্মকর্তা যোগ করুন</h5>
                        <button type="button" class="btn-close close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">নাম:*</label>
                            <input type="text" name="name" class="form-control" placeholder="যেমন: মোঃ মাহফুজ আলম" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">পদবী / দপ্তর:</label>
                            <input type="text" name="designation" class="form-control" placeholder="যেমন: মাননীয় উপদেষ্টা (তথ্য ও সম্প্রচার মন্ত্রণালয়)">
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">ছবি (Photo Upload):</label>
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Function to activate tab by name
            function activateTab(tabName) {
                if (!tabName) return;

                // Tab link mapping
                var tabLinkMap = {
                    'main': '#main-tab',
                    'features': '#features-tab',
                    'officers': '#officers-tab',
                    'mainTab': '#main-tab',
                    'featuresTab': '#features-tab',
                    'officersTab': '#officers-tab'
                };

                var paneMap = {
                    'main': 'mainTab',
                    'features': 'featuresTab',
                    'officers': 'officersTab',
                    'mainTab': 'mainTab',
                    'featuresTab': 'featuresTab',
                    'officersTab': 'officersTab'
                };

                var targetSelector = tabLinkMap[tabName];
                var targetPaneId = paneMap[tabName];

                if (targetSelector && targetPaneId) {
                    // Deactivate all
                    document.querySelectorAll('#aboutUsTabs .nav-link').forEach(function (el) {
                        el.classList.remove('active');
                        el.setAttribute('aria-selected', 'false');
                    });
                    document.querySelectorAll('#aboutUsTabsContent .tab-pane').forEach(function (el) {
                        el.classList.remove('show', 'active');
                    });

                    // Activate target
                    var targetLink = document.querySelector(targetSelector);
                    var targetPane = document.getElementById(targetPaneId);

                    if (targetLink) {
                        targetLink.classList.add('active');
                        targetLink.setAttribute('aria-selected', 'true');
                    }
                    if (targetPane) {
                        targetPane.classList.add('show', 'active');
                    }
                }
            }

            // Check URL query param 'tab'
            var urlParams = new URLSearchParams(window.location.search);
            var tabQuery = urlParams.get('tab');
            if (tabQuery) {
                activateTab(tabQuery);
            } else if (window.location.hash) {
                var hash = window.location.hash.replace('#', '');
                activateTab(hash);
            }

            // Update URL when clicking tabs
            document.querySelectorAll('#aboutUsTabs .nav-link').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    var href = this.getAttribute('href');
                    var tabName = 'main';
                    if (href === '#featuresTab') tabName = 'features';
                    else if (href === '#officersTab') tabName = 'officers';

                    if (history.pushState) {
                        var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?tab=' + tabName;
                        window.history.pushState({ path: newurl }, '', newurl);
                    }
                });
            });
        });
    </script>

@endsection
