@extends('welcome')
@section('title', 'বিএফডিসি সেবার তালিকা')

@section('body')
<style>
    .service-header {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        color: white;
        padding: 30px 0;
        margin-bottom: 20px;
    }
    .list-group-item {
        border-color: #f0f2f5;
        color: #495057;
        transition: all 0.2s ease;
        cursor: pointer;
        font-size: 14px;
        padding: 10px 14px;
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
        color: #0d6efd;
    }
    .list-group-item.active {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: #fff;
        font-weight: 600;
    }
    .table-service th {
        background-color: #f8f9fa;
        color: #333;
        font-family: 'SolaimanLipi', sans-serif;
        font-size: 13px;
        padding: 10px 12px;
    }
    .table-service td {
        font-size: 14px;
        padding: 10px 12px;
    }

    /* Sidebar & Content Box Styles */
    .sidebar-scroll-box {
        position: sticky;
        top: 100px;
        border-radius: 0px;
        background: #ffffff;
        z-index: 10;
        border: 1px solid #a7a7a7ff;
        overflow: hidden;
    }

    .content-scroll-box {
        overflow: visible;
    }

    .search-card-box {
        display: block !important;
        padding: 16px 20px !important;
        width: 100% !important;
    }
</style>


<div class="container mt-5"> 
    <h3 class="fw-bold mb-5 text-left" style="font-family: 'SolaimanLipi', sans-serif;border-bottom:2px solid #0d6efd;padding-bottom:10px;width:fit-content;margin-left:-62px">সেবাসমূহ ও ফি সমূহের বিবরণী:</h3>
</div>
  

<div class="container-fluid px-4 px-lg-5 py-2 mb-4">
    @php
        $validCategories = $categories->filter(function($cat) {
            return $cat->items && $cat->items->count() > 0;
        });

        if (!function_exists('getCategoryIcon')) {
            function getCategoryIcon($name) {
                $n = mb_strtolower($name);
                if (str_contains($n, 'স্পট') || str_contains($n, 'ভাড়া') || str_contains($n, 'ফ্লোয়ার') || str_contains($n, 'ফ্লোর')) {
                    return 'fas fa-building';
                } elseif (str_contains($n, 'ক্যামেরা') && (str_contains($n, 'আনুষঙ্গিক') || str_contains($n, 'যন্ত্রপাতি'))) {
                    return 'fas fa-sliders-h';
                } elseif (str_contains($n, 'ক্যামেরা')) {
                    return 'fas fa-video';
                } elseif (str_contains($n, 'লাইট')) {
                    return 'fas fa-lightbulb';
                } elseif (str_contains($n, 'মেটেরিয়াল') || str_contains($n, 'সেট')) {
                    return 'fas fa-cubes';
                } elseif (str_contains($n, 'এডিটিং')) {
                    return 'fas fa-film';
                } elseif (str_contains($n, 'শব্দ')) {
                    return 'fas fa-volume-up';
                } elseif (str_contains($n, 'টেলি') || str_contains($n, 'সিনে')) {
                    return 'fas fa-tv';
                } elseif (str_contains($n, 'মেডিকেল')) {
                    return 'fas fa-medkit';
                } elseif (str_contains($n, 'ল্যাব')) {
                    return 'fas fa-flask';
                } elseif (str_contains($n, 'সাব-টাইটেল') || str_contains($n, 'সাব')) {
                    return 'fas fa-closed-captioning';
                } elseif (str_contains($n, 'টাইটেল') || str_contains($n, 'এনিমেশন')) {
                    return 'fas fa-magic';
                }
                return 'fas fa-concierge-bell';
            }
        }
    @endphp

    <div class="row">
        <!-- LEFT COLUMN: Independent Scrollable Category Sidebar Menu -->
        <div class="col-lg-4 col-md-5 mb-4">
            <div class="bordered sidebar-scroll-box">
                <div class="list-group list-group-flush" id="categoryTabs" role="tablist">
                    @foreach($validCategories as $index => $cat)
                        @php
                            $catIcon = getCategoryIcon($cat->name_bn ?: $cat->name_en);
                        @endphp
                        <button class="list-group-item list-group-item-action {{ $loop->first ? 'active' : '' }} py-2.5 px-3 d-flex justify-content-between align-items-center" data-category="cat-{{ $cat->id }}" style="font-family: 'SolaimanLipi', sans-serif;">
                            <span class="text-truncate me-2 mr-2"><i class="{{ $catIcon }} cat-icon me-2 mr-2 {{ $loop->first ? 'text-white' : 'text-primary' }}"></i> {{ $cat->name_bn ?: $cat->name_en }}</span>
                            <span class="badge {{ $loop->first ? 'bg-white text-primary' : 'bg-secondary' }} rounded-pill" style="font-size: 11px;">{{ $cat->items->count() }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Independent Scrollable Content Area -->
        <div class="col-lg-8 col-md-7 mb-4">
            <div class="content-scroll-box">
                <!-- Search Bar & Total Services Card -->
                <div class="mb-4 search-card-box">
                    <div class="row align-items-center g-2 g-md-3">
                        <div class="col-12 col-md-8 col-lg-8">
                            <div class="input-group w-100">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-search" style="font-size: 14px;"></i></span>
                                <input type="text" id="serviceSearch" class="form-control bg-light border-start-0" placeholder="সেবার নাম লিখে খুঁজুন..." style="font-family: 'SolaimanLipi', sans-serif; font-size: 14px; height: 42px;">
                            </div>
                        </div>
                       
                    </div>
                </div>

                <!-- Services List Container -->
                <div id="servicesContainer">
                    @if($validCategories->count() > 0)
                        @foreach($validCategories as $cat)
                            @php
                                $catIcon = getCategoryIcon($cat->name_bn ?: $cat->name_en);
                            @endphp
                            <div class="service-category-block cat-block cat-{{ $cat->id }}" style="display: {{ $loop->first ? 'block' : 'none' }};">
                                <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                                    <i class="{{ $catIcon }} text-primary fs-5 me-2 mr-2"></i>
                                    <h4 class="fw-bold mb-0 text-dark" style="font-family: 'SolaimanLipi', sans-serif; font-size: 18px;">
                                        {{ $cat->name_bn ?: $cat->name_en }}
                                    </h4>
                                    <span class="badge bg-light text-dark border ms-auto" style="font-family: 'SolaimanLipi', sans-serif; font-size: 12px;">
                                        {{ $cat->items->count() }} টি সেবা
                                    </span>
                                </div>

                                <div class="table-responsive shadow-sm" style="border-radius: 0px; border: 1px solid #e2e8f0; background: #ffffff;">
                                    <table class="table table-hover align-middle mb-0 table-service">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">#</th>
                                                <th style="width: 40%;">সেবার নাম</th>
                                                <th style="width: 15%;">বিভাগ/শাখা</th>
                                                <th style="width: 15%;">একক/মেয়াদ</th>
                                                <th style="width: 15%;" class="text-end">ফি (টাকা)</th>
                                                <th style="width: 10%;" class="text-center">স্ট্যাটাস</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cat->items as $index => $item)
                                                <tr class="service-row">
                                                    <td class="text-muted fw-bold" style="font-size: 13px;">{{ $index + 1 }}</td>
                                                    <td>
                                                        <div class=" text-dark service-name" style="font-family: 'SolaimanLipi', sans-serif; font-size: 14px;">
                                                            {{ $item->name_bn ?: $item->name_en }}
                                                        </div>
                                                        @if(!empty($item->description))
                                                            <small class="text-muted d-block" style="font-family: 'SolaimanLipi', sans-serif; font-size: 12px;">{{ $item->description }}</small>
                                                        @endif
                                                    </td>
                                                    <td style="font-family: 'SolaimanLipi', sans-serif; font-size: 13px;">
                                                        <span class="badge bg-light text-secondary border" style="font-size: 11px;">
                                                            {{ $item->department ? ($item->department->name_bn ?: ($item->department->name_en ?: $item->department->name)) : 'সাধারণ' }}
                                                        </span>
                                                    </td>
                                                    <td style="font-family: 'SolaimanLipi', sans-serif; font-size: 13px;">
                                                        {{ $item->unit ? ($item->unit->name_bn ?: $item->unit->name_en) : '-' }}
                                                        @if($item->duration)
                                                            <span class="text-muted small">({{ $item->duration }} দিন)</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-end fw-bold text-success" style="font-family: 'SolaimanLipi', sans-serif; font-size: 14px;">
                                                        ৳ {{ number_format($item->amount, 2) }}
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-success px-2 py-1" style="font-family: 'SolaimanLipi', sans-serif; font-size: 11px;">সক্রিয়</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-info text-center py-5" style="border-radius: 0px;">
                            <i class="fas fa-info-circle fa-2x mb-3 text-info"></i>
                            <h5 style="font-family: 'SolaimanLipi', sans-serif;">বর্তমানে কোনো সেবার তথ্য উপলব্ধ নেই।</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Category Tab Menu (Vertical Sidebar)
    const tabBtns = document.querySelectorAll('#categoryTabs .list-group-item');
    const catBlocks = document.querySelectorAll('.cat-block');
    const contentScrollBox = document.querySelector('.content-scroll-box');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            tabBtns.forEach(b => {
                b.classList.remove('active');
                const icon = b.querySelector('.cat-icon');
                if (icon) {
                    icon.classList.remove('text-white');
                    icon.classList.add('text-primary');
                }
                const badge = b.querySelector('.badge');
                if (badge) {
                    badge.classList.remove('bg-white', 'text-primary');
                    badge.classList.add('bg-secondary');
                }
            });

            this.classList.add('active');
            const activeIcon = this.querySelector('.cat-icon');
            if (activeIcon) {
                activeIcon.classList.remove('text-primary');
                activeIcon.classList.add('text-white');
            }
            const activeBadge = this.querySelector('.badge');
            if (activeBadge) {
                activeBadge.classList.remove('bg-secondary');
                activeBadge.classList.add('bg-white', 'text-primary');
            }

            const cat = this.getAttribute('data-category');
            catBlocks.forEach(block => {
                if (block.classList.contains(cat)) {
                    block.style.display = 'block';
                } else {
                    block.style.display = 'none';
                }
            });


        });
    });

    // 2. Realtime Search Filter
    const searchInput = document.getElementById('serviceSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const query = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('.service-row');

            if (query === '') {
                const activeBtn = document.querySelector('#categoryTabs .list-group-item.active');
                const cat = activeBtn ? activeBtn.getAttribute('data-category') : null;
                catBlocks.forEach(block => {
                    if (cat && block.classList.contains(cat)) {
                        block.style.display = 'block';
                    } else {
                        block.style.display = 'none';
                    }
                });
                rows.forEach(row => row.style.display = '');
            } else {
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });

                catBlocks.forEach(block => {
                    const visibleRows = block.querySelectorAll('.service-row:not([style*="display: none"])');
                    if (visibleRows.length > 0) {
                        block.style.display = 'block';
                    } else {
                        block.style.display = 'none';
                    }
                });
            }
        });
    }
});
</script>
@endsection
