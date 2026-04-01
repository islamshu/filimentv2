@extends('layouts.frontend')

@section('title', $product->name)

@section('styles')
    <style>
        .container.product-page {
            margin-top: 180px !important;
        }

        @media (max-width: 768px) {
            .container.product-page {
                margin-top: 120px !important;
            }
        }

        .product-gallery-card,
        .product-info-card {
            background: #fff;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            padding: 16px 18px;
        }

        .product-title-main {
            font-size: 22px;
            font-weight: 700;
        }

        .product-meta {
            font-size: 14px;
            color: #6b7280;
        }

        .badge-stock {
            font-size: 13px;
            padding: 4px 10px;
            border-radius: 999px;
        }

        .badge-stock.in-stock {
            background: #ecfdf3;
            color: #166534;
        }

        .price-block {
            padding: 12px 14px;
            border-radius: 10px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
        }

        .price-main {
            font-size: 24px;
            font-weight: 800;
            color: #dc2626;
        }

        .price-old {
            font-size: 14px;
            text-decoration: line-through;
            color: #9ca3af;
            margin-right: 8px;
        }

        .price-saving {
            font-size: 13px;
            color: #059669;
        }

        .installment-text {
            font-size: 13px;
            color: #4b5563;
        }

        .btn-add-cart-main {
            width: 100%;
            font-weight: 700;
            padding: 10px 0;
            border-radius: 10px;
        }

        .wishlist-link {
            font-size: 13px;
            color: #6b7280;
        }

        .breadcrumb {
            font-size: 13px;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            font-family: 'Font Awesome 6 Free';
            content: '\f053' !important;
            font-weight: 600;
            font-size: 10px;
            margin-top: 6px;
        }

        .swiper {
            width: 100%;
            margin-left: auto;
            margin-right: auto;
        }

        .swiper-slide {
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            overflow: hidden;
        }

        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
            user-select: none;
            -webkit-user-drag: none;
        }

        .p-main-swiper {
            height: 360px;
            margin-bottom: 10px;
            border-radius: 10px;
            overflow: hidden;
        }

        .thumbnail-wrapper {
            position: relative;
            width: 100%;
        }

        .p-thumbs-swiper {
            height: 100px;
            box-sizing: border-box;
            padding: 6px 0;
        }

        .p-thumbs-swiper .swiper-wrapper {
            display: flex;
        }

        .p-thumbs-swiper .swiper-slide {
            width: 80px !important;
            height: 90px;
            opacity: 0.55;
            padding: 4px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #fff;
            transition: 0.18s ease;
        }

        .p-thumbs-swiper .swiper-slide:hover {
            opacity: 0.85;
            transform: translateY(-1px);
        }

        .p-thumbs-swiper .swiper-slide-thumb-active {
            opacity: 1;
            border: 2px solid #00baf2;
        }

        .thumb-arrow {
            width: 32px;
            height: 32px;
            background: #ffffff;
            border: 1px solid #c8c8c8;
            border-radius: 50%;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #333;
            transition: 0.15s ease;
        }

        .thumb-arrow:hover {
            background: #f9fafb;
            transform: translateY(-50%) scale(1.03);
        }

        .thumb-prev {
            right: -16px;
        }

        .thumb-next {
            left: -16px;
        }

        .swiper-button-prev,
        .swiper-rtl .swiper-button-next {
            left: var(--swiper-navigation-sides-offset, 8px);
            right: auto;
            border: 1px solid #c8c8c8;
            color: #777777;
            padding: 4px;
            border-radius: 50%;
            height: 28px;
            width: 28px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(4px);
            transition: 0.15s ease;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            transform: scale(1.03);
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 13px;
            font-weight: 700;
        }

        .product-tabs {
            margin-top: 40px;
        }

        .product-tabs .nav-link {
            font-size: 14px;
            font-weight: 700;
            padding: 10px 16px;
        }

        .product-tabs .nav-link.active {
            color: #00baf2;
        }

        .description-content {
            line-height: 1.9;
            color: #4b5563;
            font-size: 14px;
        }

        .product-comments-wrapper {
            margin-top: 20px;
        }

        .product-comment {
            padding: 14px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .product-comment:last-of-type {
            border-bottom: 0;
        }

        .comment-name {
            font-size: 14px;
            font-weight: 700;
        }

        .comment-meta {
            font-size: 12px;
            color: #6b7280;
        }

        .comment-text {
            font-size: 13px;
            color: #374151;
            margin-top: 6px;
        }

        .comment-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
        }

        .related-section {
            margin-top: 50px;
            margin-bottom: 30px;
        }

        .related-title {
            font-size: 18px;
            font-weight: 800;
        }

        .related-product-card {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px;
            background: #fff;
            transition: box-shadow 0.2s ease, transform 0.1s ease;
        }

        .related-product-card:hover {
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
            transform: translateY(-2px);
        }

        .related-name {
            font-size: 13px;
            font-weight: 600;
            min-height: 36px;
        }

        .related-price {
            font-size: 14px;
            font-weight: 800;
            color: #dc2626;
        }

        .related-price-old {
            font-size: 12px;
            text-decoration: line-through;
            color: #9ca3af;
        }

        .btn-related-add {
            font-size: 12px;
            padding: 6px 10px;
        }

        .btn-related-icon {
            width: 32px;
            height: 32px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-lightbox {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .image-lightbox.active {
            display: flex;
        }

        .image-lightbox-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.75);
        }

        .image-lightbox-content {
            position: relative;
            width: min(980px, 95vw);
            height: min(680px, 90vh);
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(17, 24, 39, .92);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 20px 80px rgba(0,0,0,.45);
            animation: lbPop .18s ease;
        }

        @keyframes lbPop {
            from { transform: scale(.985); opacity: .75; }
            to { transform: scale(1); opacity: 1; }
        }

        .image-lightbox-content img.lb-img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 6px;
            background: #000;
            display: block;
        }

        .lb-close {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(0,0,0,.35);
            border: 1px solid rgba(255,255,255,.14);
            color: #fff;
            width: 44px;
            height: 44px;
            border-radius: 999px;
            font-size: 22px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: .15s ease;
        }

        .lb-close:hover {
            transform: scale(1.03);
            background: rgba(0,0,0,.55);
        }

        .lb-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(15,23,42,0.65);
            border: 1px solid rgba(255,255,255,.12);
            color: #fff;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.15s ease;
        }

        .lb-nav:hover {
            transform: translateY(-50%) scale(1.03);
            background: rgba(15,23,42,0.8);
        }

        .lb-prev {
            right: 10px;
        }

        .lb-next {
            left: 10px;
        }

        @media (max-width: 767.98px) {
            .product-page {
                margin-top: 20px;
            }

            .product-title-main {
                font-size: 18px;
            }

            .p-main-swiper {
                height: 300px;
            }

            .p-thumbs-swiper {
                height: 80px;
            }

            .thumb-arrow {
                display: none !important;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>
@endsection

@section('content')
    @php
        $reviews = App\Models\Comment::where('page_or_product', 'products')
            ->orderBy('id', 'desc')
            ->get();

        $reviewsCount = $reviews->count();
        $avgStars = $reviewsCount ? round($reviews->avg('stars'), 1) : 5;
        $fullStars = floor($avgStars);
        $halfStar = ($avgStars - $fullStars) >= 0.5;
        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

        $mainUrl = $product->getImageUrl();

        $extra = collect();
        if (isset($product->images)) {
            $extra = $product->images->sortBy('sort_order')->map(function ($img) {
                $p = $img->image ?? '';
                if (!$p) return null;

                if (str_starts_with($p, 'http://') || str_starts_with($p, 'https://')) {
                    return $p;
                }

                if (str_starts_with($p, 'storage/')) {
                    return asset($p);
                }

                return asset('storage/' . $p);
            })->filter();
        }

        $gallery = collect([$mainUrl])->merge($extra)->filter()->unique()->values();
    @endphp

    <section class="container product-page">

        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item">
                        <a href="#" class="text-info text-decoration-none">الرئيسية</a>
                    </li>

                    @if ($product->subcategory)
                        <li class="breadcrumb-item">
                            <a href="{{ route('category.slug', $product->subcategory->slug) }}"
                                class="text-info text-decoration-none">
                                {{ $product->subcategory->name }}
                            </a>
                        </li>
                    @endif

                    <li class="breadcrumb-item active text-dark" aria-current="page">
                        {{ $product->name }}
                    </li>
                </ol>
            </nav>

            <h2 class="fw-bold mt-2 mb-1 text-dark">
                {{ $product->name }}
            </h2>

            <div class="d-flex align-items-center gap-2 mt-1 product-meta">
                <div class="d-flex align-items-center">
                    @for ($i = 0; $i < $fullStars; $i++)
                        <i class="fa fa-star text-warning"></i>
                    @endfor

                    @if ($halfStar)
                        <i class="fa fa-star-half-stroke text-warning"></i>
                    @endif

                    @for ($i = 0; $i < $emptyStars; $i++)
                        <i class="fa fa-star text-secondary opacity-25"></i>
                    @endfor

                    <span class="ms-1">({{ $reviewsCount }} تقييم)</span>
                </div>

                <span class="mx-2">•</span>

                <span>
                    الحالة:
                    <span class="badge badge-stock in-stock">متوفر في المخزون 14 منتجات</span>
                </span>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="product-gallery-card">

                    <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff;"
                        class="swiper p-main-swiper">
                        <div class="swiper-wrapper">
                            @forelse($gallery as $index => $imgUrl)
                                <div class="swiper-slide">
                                    <img
                                        src="{{ $imgUrl }}"
                                        alt="{{ $product->name }}"
                                        class="itemImage"
                                        loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                        fetchpriority="{{ $index === 0 ? 'high' : 'auto' }}"
                                        decoding="async"
                                        draggable="false"
                                    >
                                </div>
                            @empty
                                <div class="swiper-slide">
                                    <img
                                        src="{{ $product->getImageUrl() }}"
                                        alt="{{ $product->name }}"
                                        class="itemImage"
                                        loading="eager"
                                        fetchpriority="high"
                                        decoding="async"
                                        draggable="false"
                                    >
                                </div>
                            @endforelse
                        </div>

                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>

                    <div class="thumbnail-wrapper mt-3">
                        <div class="thumb-arrow thumb-prev d-none d-md-flex" role="button" aria-label="prev thumbs">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>

                        <div class="swiper p-thumbs-swiper">
                            <div class="swiper-wrapper">
                                @forelse($gallery as $imgUrl)
                                    <div class="swiper-slide">
                                        <img loading="lazy" decoding="async" src="{{ $imgUrl }}"
                                            alt="{{ $product->name }}">
                                    </div>
                                @empty
                                    <div class="swiper-slide">
                                        <img loading="lazy" decoding="async" src="{{ $product->getImageUrl() }}"
                                            alt="{{ $product->name }}">
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="thumb-arrow thumb-next d-none d-md-flex" role="button" aria-label="next thumbs">
                            <i class="fa-solid fa-chevron-left"></i>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-6">
                <div class="product-info-card">

                    <div class="mb-2">
                        <span class="product-meta">
                            {{ get_general_value('daman_text') }}
                        </span>
                    </div>

                    <div class="price-block mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="price-main">
                                    {{ $product->discount == 0 ? $product->price : $product->price - $product->discount }}
                                </span>
                                <span class="price-main" style="font-size: 18px;">
                                    {{ get_currancy() }}
                                </span>
                            </div>

                            @if ($product->discount != 0)
                                <div class="text-end">
                                    <div>
                                        <span class="price-old">
                                            {{ $product->price }} {{ get_currancy() }}
                                        </span>
                                    </div>
                                    <div class="price-saving">
                                        وفر {{ $product->discount }} {{ get_currancy() }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="installment-text mt-2">
                            يوفر متجر {{ get_general_value('website_name') }} {{ $product->name }} مع إمكانية تقسيط تابي أو
                            تقسيط تمارا بالإضافة إلى خطط دفع سهلة وميسرة من بنوك أخري
                        </div>
                    </div>

                    <form action="{{ route('cart.store') }}" method="POST" class="mb-3">
                        @csrf
                        <input type="hidden" name="qnt" value="1">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="row g-2 align-items-center mb-3">
                            <div class="col-12">
                                <button type="submit" name="addCart" class="btn primaryColor btn-add-cart-main">
                                    أضف إلى السلة
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                        <div>
                            <i class="fa-solid fa-heart me-2 text-secondary"></i>
                            <a href="#" class="wishlist-link">أضافة لقائمة الامنيات</a>
                        </div>
                        <div>
                            <i class="fa-solid fa-share-nodes text-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-tabs">
            <ul class="nav nav-tabs" id="productTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                        data-bs-target="#description" type="button" role="tab"
                        aria-controls="description" aria-selected="true">
                        وصف المنتج
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab"
                        data-bs-target="#reviews" type="button" role="tab"
                        aria-controls="reviews" aria-selected="false">
                        تقييمات المنتج ({{ $reviewsCount }})
                    </button>
                </li>
            </ul>

            <div class="tab-content border border-top-0 rounded-bottom p-3" id="productTabContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel"
                    aria-labelledby="description-tab">
                    <div class="description-content">
                        {!! $product->description !!}
                    </div>
                </div>

                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                    <div class="product-comments-wrapper">
                        @if ($reviewsCount == 0)
                            <p class="text-muted mb-0" style="font-size: 14px;">
                                لا توجد تقييمات لهذا المنتج حتى الآن.
                            </p>
                        @else
                            @foreach ($reviews as $item)
                                @php
                                    $fullStarsItem = floor($item->stars);
                                    $halfStarItem = ($item->stars - $fullStarsItem) >= 0.5;
                                    $emptyStarsItem = 5 - $fullStarsItem - ($halfStarItem ? 1 : 0);
                                @endphp

                                <div class="product-comment">
                                    <div class="row">
                                        <div class="col-10 d-flex">
                                            <img src="{{ asset('front/assets/image/icons/profile.png') }}"
                                                alt="profile" class="comment-avatar">

                                            <div class="ms-2 flex-grow-1">
                                                <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                                    <span class="comment-name">{{ $item->name }}</span>
                                                    <span class="comment-meta">
                                                        <i class="fa fa-check"
                                                            style="width: 20px;height: 20px;border-radius: 50%;background-color: gold;text-align:center;line-height:20px;"></i>
                                                        قام بالشراء, تم التقييم
                                                    </span>
                                                </div>

                                                <div class="mb-1">
                                                    @for ($i = 0; $i < $fullStarsItem; $i++)
                                                        <i class="fa fa-star"
                                                            style="color: gold;font-size: 13px;"></i>
                                                    @endfor

                                                    @if ($halfStarItem)
                                                        <i class="fa fa-star-half-o"
                                                            style="color: gold;font-size: 13px;"></i>
                                                    @endif

                                                    @for ($i = 0; $i < $emptyStarsItem; $i++)
                                                        <i class="fa fa-star-o"
                                                            style="color: gold;font-size: 13px;"></i>
                                                    @endfor
                                                </div>

                                                <p class="comment-text mb-0">
                                                    {{ $item->comment }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="col-2 text-end">
                                            <span class="comment-meta">
                                                {{ $item->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <section class="related-section">
            <h3 class="related-title mb-3">
                منتجات قد تعجبك
            </h3>

            <div class="slider" dir="ltr">
                @foreach ($product->similarProducts(session('country_id')) as $item)
                    <a href="{{ route('single_product', $item->id) }}" class="text-decoration-none">
                        <div class="related-product-card product">

                            <div class="product-entry__image mb-2">
                                <img loading="lazy"
                                    decoding="async"
                                    src="{{ asset($item->getImageUrl()) }}"
                                    class="d-block m-auto"
                                    style="object-fit:contain;width:100%;max-height:200px;"
                                    alt="{{ $item->name }}">
                            </div>

                            <div class="position-relative">
                                <p class="related-name mb-1">
                                    {{ $item->name }}
                                </p>

                                <div class="mb-2">
                                    <span class="related-price">
                                        {{ $item->discount == 0 ? $item->price : $item->price - $item->discount }}
                                        {{ get_currancy() }}
                                    </span>

                                    @if ($item->discount != 0)
                                        <span class="related-price-old ms-2">
                                            {{ $item->price }} {{ get_currancy() }}
                                        </span>
                                    @endif
                                </div>

                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="qnt" value="1">
                                    <input type="hidden" name="product_id" value="{{ $item->id }}">

                                    <div class="d-flex align-items-center gap-2">
                                        <button type="submit" name="addCart"
                                            class="btn btn-sm btn-pro btn-related-icon loveBtn">
                                            <img loading="lazy"
                                                decoding="async"
                                                src="{{ asset('front/assets/image/icons/heart.png') }}"
                                                width="18" height="18" alt="">
                                        </button>
                                        <button type="submit" name="addCart"
                                            class="btn btn-sm btn-pro btn-related-add addTCartBtn">
                                            إضافة للسلة
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </a>
                @endforeach
            </div>
        </section>

        <div id="imageLightbox" class="image-lightbox">
            <div class="image-lightbox-backdrop"></div>
            <div class="image-lightbox-content">
                <button type="button" class="lb-close" aria-label="close">&times;</button>
                <button type="button" class="lb-nav lb-prev" aria-label="prev">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
                <img src="" alt="product image" class="lb-img">
                <button type="button" class="lb-nav lb-next" aria-label="next">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
            </div>
        </div>

    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Swiper === 'undefined') return;

            var mainEl = document.querySelector(".p-main-swiper");
            var thumbsEl = document.querySelector(".p-thumbs-swiper");
            if (!mainEl || !thumbsEl) return;

            var slidesCount = mainEl.querySelectorAll('.swiper-wrapper .swiper-slide').length;

            var thumbsSwiper = new Swiper(".p-thumbs-swiper", {
                slidesPerView: "auto",
                spaceBetween: 10,
                freeMode: true,
                watchSlidesProgress: true,
                breakpoints: {
                    0: { slidesPerView: 4 },
                    768: { slidesPerView: 5 }
                }
            });

            var mainSwiper = new Swiper(".p-main-swiper", {
                loop: slidesCount > 1,
                spaceBetween: 10,
                navigation: {
                    nextEl: ".p-main-swiper .swiper-button-next",
                    prevEl: ".p-main-swiper .swiper-button-prev",
                },
                thumbs: {
                    swiper: thumbsSwiper
                },
                watchOverflow: true,
                observer: true,
                observeParents: true
            });

            var prevBtn = document.querySelector(".thumb-prev");
            var nextBtn = document.querySelector(".thumb-next");

            if (prevBtn) prevBtn.addEventListener("click", function () { thumbsSwiper.slidePrev(); });
            if (nextBtn) nextBtn.addEventListener("click", function () { thumbsSwiper.slideNext(); });

            var lightbox = document.getElementById('imageLightbox');
            if (!lightbox) return;

            var lbImg = lightbox.querySelector('.lb-img');
            var lbClose = lightbox.querySelector('.lb-close');
            var lbPrev = lightbox.querySelector('.lb-prev');
            var lbNext = lightbox.querySelector('.lb-next');
            var backdrop = lightbox.querySelector('.image-lightbox-backdrop');

            if (!lbImg || !lbClose || !lbPrev || !lbNext || !backdrop) return;

            var currentIndex = 0;

            function getGalleryImages() {
                var slides = Array.from(document.querySelectorAll('.p-main-swiper .swiper-slide'));
                var originals = slides.filter(function (s) {
                    return !s.classList.contains('swiper-slide-duplicate');
                });

                var imgs = originals.map(function (s) { return s.querySelector('img'); }).filter(Boolean);

                if (!imgs.length) imgs = Array.from(document.querySelectorAll('.p-main-swiper img'));
                return imgs;
            }

            function openLightbox(index) {
                var galleryImages = getGalleryImages();
                if (!galleryImages.length) return;

                if (index < 0) index = galleryImages.length - 1;
                if (index >= galleryImages.length) index = 0;

                currentIndex = index;
                lbImg.src = galleryImages[currentIndex].currentSrc || galleryImages[currentIndex].src;

                lightbox.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeLightbox() {
                lightbox.classList.remove('active');
                document.body.style.overflow = '';
            }

            mainEl.addEventListener('click', function (e) {
                var img = e.target.closest('img');
                if (!img) return;

                img.style.cursor = 'zoom-in';

                if (mainSwiper) {
                    openLightbox(mainSwiper.realIndex);
                } else {
                    openLightbox(0);
                }
            });

            lbClose.addEventListener('click', closeLightbox);
            backdrop.addEventListener('click', closeLightbox);

            lbPrev.addEventListener('click', function () {
                openLightbox(currentIndex - 1);
            });

            lbNext.addEventListener('click', function () {
                openLightbox(currentIndex + 1);
            });

            document.addEventListener('keyup', function (e) {
                if (!lightbox.classList.contains('active')) return;

                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowLeft') openLightbox(currentIndex - 1);
                if (e.key === 'ArrowRight') openLightbox(currentIndex + 1);
            });
        });
    </script>
@endsection