@extends('layouts.frontend')
@section('title', $product->name)
@section('styles')
    <style>
          @media (min-width: 571px) {
            .maxhi {
                max-height: 500px;
                /* overflow-y: auto; */
            }
        }
        .breadcrumb-item+.breadcrumb-item::before {
            font-family: 'Font Awesome 6 Free';
            content: '\f053' !important;
            font-weight: 600;
            font-size: 12px;
            margin-top: 5px;
        }

        .rounded {
            border-radius: 4px !important;
        }

        .product-comment.div:last-of-type {
            border-bottom: unset !important;
        }


        .slick-prev,
        .slick-next {
            font-size: 0;
            line-height: 0;
            position: absolute;
            top: 50%;
            display: block;
            width: 32px;
            height: 32px;
            padding: 0;
            -webkit-transform: translate(0, -50%);
            -ms-transform: translate(0, -50%);
            transform: translate(0, -50%);
            cursor: pointer;
            border: 1px solid #e5e7eb !important;
            outline: none;
            background: transparent;
            border-radius: 50% !important;
        }

        .slick-prev:before,
        .slick-next:before {
            color: #333 !important;
            font-size: 15px;
        }

        [dir='rtl'] .slick-next:before {
            font-family: 'Font Awesome 6 Free';
            content: '\f053' !important;

            font-weight: 600;

        }

        [dir='rtl'] .slick-prev:before {
            font-family: 'Font Awesome 6 Free';
            content: '\f054' !important;

            font-weight: 600;

        }

        [dir='rtl'] .slick-next {
            right: auto;
            left: 8px;
            top: -30px !important;
        }

        [dir='rtl'] .slick-prev {
            right: auto;
            left: 50px;
            top: -30px !important;
        }




        .swiper {
            width: 80%;
            height: 80%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .swiper {
            width: 100%;
            height: 300px;
            margin-left: auto;
            margin-right: auto;
        }

        .swiper-slide {
            background-size: cover;
            background-position: center;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
        }

        .mySwiper2 {
            height: 62%;
            width: 100%;
        }

        .mySwiper2 .swiper-slide {
            padding: 10px !important;
        }

        .mySwiper2 .swiper-slide img {
            object-fit: contain !important;
            max-height: unset !important;
        }

        .mySwiper {
            height: 20%;
            box-sizing: border-box;
            padding: 10px 0;
        }

        .mySwiper .swiper-slide {
            width: 100% !important;
            /* height: 100%; */
            opacity: 0.4;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 4px 0px;
            margin-bottom: 10px;
        }

        .mySwiper .swiper-slide-thumb-active {
            opacity: 1;
            border: 2px solid #00baf2;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .swiper-button-prev,
        .swiper-rtl .swiper-button-next {
            left: var(--swiper-navigation-sides-offset, 10px);
            right: auto;
            border: 1px solid #c8c8c8;
            color: #777777;
            padding: 4px;
            border-radius: 50%;
            height: 30px;
            width: 30px;
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 13px;
            font-weight: 700;
        }

        .swiper-button-next:after {
            margin-right: 2px;
        }

        .swiper-button-prev:after {
            margin-left: 2px;
        }

         .product-description {
            margin-top: 40px;
            border-top: 1px solid #eee;
            padding-top: 30px;
        }
        
        .description-title {
            position: relative;
            margin-bottom: 20px;
        }
        
        .description-title h4 {
            display: inline-block;
            background: #fff;
            padding-right: 15px;
            position: relative;
            z-index: 2;
            color: #00baf2;
        }
        
        .description-title:after {
            content: "";
            position: absolute;
            top: 50%;
            right: 0;
            width: 100%;
            height: 1px;
            background: #eee;
            z-index: 1;
        }
        
        .description-content {
            line-height: 1.8;
            color: #555;
        }
        @media (max-width:570px) {
            .minH {
                height: 330px;
            }

            .minH2 {
                height: -100px;
            }

            .breadcrumb {
                font-size: 14px;
            }

            .fa-star {
                font-size: 14px;
            }

            .fa-star-half-stroke {
                font-size: 14px;
            }

            .fs-sm {
                font-size: 13px !important;
            }

            .sSm {
                margin-top: -1rem !important;
            }
        }
    </style>
@endsection
@section('content')
    <section class="mt-5 py-3 sSm" style="margin-bottom: 90px !important;">
    </section>
    <section class="container">


        <h5 class="text-start text-secondary d-md-none  container-fluid">
            {{ $product->name }}</h5>
        <!-- details -->
        <div class="container-fluid">
            <div class="row " >
                <div class="col-md-6 minH maxhi">
                    <div class="row">


                        <div class="col-3">
                            <div thumbsSlider="" class="swiper mySwiper" style="overflow:visible !important">
                                <div class="swiper-wrapper d-flex flex-column" style="height: 80% !important;">
                                    <div class="swiper-slide">
                                        <img src="{{ $product->getImageUrl() }}" class="itemImage ms-auto me-auto"
                                            alt="{{ $product->name }}">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="{{ $product->getImageUrl() }}" class="itemImage ms-auto me-auto"
                                            alt="{{ $product->name }}">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="{{ $product->getImageUrl() }}" class="itemImage ms-auto me-auto"
                                            alt="{{ $product->name }}">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="{{ $product->getImageUrl() }}" class="itemImage ms-auto me-auto"
                                            alt="{{ $product->name }}">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-9">
                            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff;"
                                class="swiper mySwiper2">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="{{ $product->getImageUrl() }}" class="itemImage ms-auto me-auto"
                                            alt="{{ $product->name }}">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="{{ $product->getImageUrl() }}" class="itemImage ms-auto me-auto"
                                            alt="{{ $product->name }}">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="{{ $product->getImageUrl() }}" class="itemImage ms-auto me-auto"
                                            alt="{{ $product->name }}">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="{{ $product->getImageUrl() }}" class="itemImage ms-auto me-auto"
                                            alt="{{ $product->name }}">
                                    </div>

                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    </div>



                </div>
                <div class="col-md-6 minH2 maxhi mt-md-0 mt-2 py-3">



                    <nav aria-label="breadcrumb ">
                        <ol class="breadcrumb mt-4">
                            <li class="breadcrumb-item text-info"><a href="#" class="text-info text-decoration-none"
                                    style="font-size: 14px;">الرئيسية</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('category.slug', $product->subcategory->slug) }}"
                                    class=" text-info text-decoration-none">{{ $product->subcategory->name }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>

                        </ol>
                    </nav>


                    <h2 class="d-md-block d-none fw-bold mb-3">{{ $product->name }}</h2>
                    <span class="mb-3 d-inline-block fw-bold text-body-secondary" style="font-size: 15px;color:gray">
                        {{ get_general_value('daman_text') }}</span>
                    <p class="text-success fw-bold"> <span class="text-body fw-normal">الحالة:</span> متوفر في المخزون 14
                        منتجات
                    </p>
                    <div class="row">

                        <div class="col-5 col-lg-6 d-flex">
                            <div class="text-start text-warning">
                                <i class="fas fa-star-half-stroke"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <span class="fs-6 fs-sm">({{ rand(40, 50) }} تقييم)</span>
                        </div>
                        <div class="col-6 col-lg-5">
                            <i class="fa-solid fa-heart me-2"></i>
                            <a href="#" class="text-secondary fs-sm">أضافة لقائمة الامنيات </a>
                        </div>

                        <div class="col-1 col-lg-1">
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                    </div>

                    <div class="mt-2 mb-2">
                        <p>يوفر متجر {{ get_general_value('website_name') }} {{ $product->name }} مع إمكانية تقسيط تابي أو
                            تقسيط تمارا بالإضافة إلى خطط دفع سهلة وميسرة من بنوك أخري
                        </p>
                    </div>


                    <div class="row">
                    </div>
                    <div class="row my-3">

                    </div>
                    <form action="{{ route('cart.store') }}" method="POST" style="width: 100%; padding:0 !important">
                        @csrf
                        <input type="hidden" name="qnt" value="1" id="">
                        <input type="hidden" name="product_id" value=" {{ $product->id }}" id="">
                        <div class="row">
                            <div class="col-6 d-flex">




                            </div>

                            <div class="col-6 text-end">
                                <span
                                    class="text-danger fw-bold fs-4">{{ $product->discount == 0 ? $product->price : $product->price - $product->discount }}
                                    {{ get_general_value('currancy') }}
                                </span>

                                @if ($product->discount != 0)
                                    <span class="text-decoration-line-through text-secondary ms-2">{{ $product->price }}
                                        {{ get_general_value('currancy') }} </span>
                                @endif

                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" name="addCart" class="btn primaryColor w-100">أضف إلى
                                    السلة</button>
                            </div>
                        </div>
                    </form>
                </div>
                 <div class="col-12 product-description">
                    <div class="description-title">
                        <h4>وصف المنتج</h4>
                    </div>
                    <div class="description-content">
                        {!! $product->description !!}
                    </div>
                </div>
            </div>



            <div class="product-comments pt-4 border"
                style="margin-top: 60px; border-top:2px solid #00baf2 !important; position:relative">
                <span
                    style="position: absolute;top:-41px;right:-1px;background-color:#00baf2;color:white;padding:8px 26px;border-top-left-radius:5px;border-top-right-radius:5px;">تقيمات
                    المنتج</span>
                @foreach (App\Models\Comment::where('product_id', $product->id)->orderBy('id', 'desc')->get() as $item)
    @php
        $fullStars = floor($item->stars);
        $halfStar = ($item->stars - $fullStars) >= 0.5;
        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
    @endphp

    <div class="product-comment mb-3 pb-4">
        <div class="row">
            <div class="col-10 d-flex text-start">
                <img src="{{ asset('front/assets/image/icons/profile.png') }}" width="50" height="50" alt="">
                <div class="d-flex flex-column ms-2">
                    <div class="mb-1">
                        <span class="fw-bold">{{ $item->name }}</span>
                        <span class="ms-3">
                            <i class="fa fa-check"
                                style="width: 25px; height: 25px; border-radius: 50%; background-color: gold; text-align: center; line-height: 15px; padding-top: 5px;"></i>
                            قام بالشراء, تم التقييم
                        </span>
                    </div>

                    {{-- عرض النجوم --}}
                    <div class="d-flex mb-2">
                        @for ($i = 0; $i < $fullStars; $i++)
                            <i class="fa fa-star" style="color: gold;"></i>
                        @endfor

                        @if ($halfStar)
                            <i class="fa fa-star-half-o" style="color: gold;"></i>
                        @endif

                        @for ($i = 0; $i < $emptyStars; $i++)
                            <i class="fa fa-star-o" style="color: gold;"></i>
                        @endfor
                    </div>

                    <p class="text-body" style="font-size: 14px;">{{ $item->comment }}</p>
                </div>
            </div>

            <div class="col-2 text-end">
                <span class="text-body" style="font-size: 13px;">
                    {{ $item->created_at->diffForHumans() }}
                </span>
            </div>
        </div>

        <hr class="ps-2 pe-2">
    </div>
@endforeach



               





            </div>





        </div>
        </div>

    </section>

    <!-- /navs -->

    <section class="container">
        <h3 class="text-start my-md-4 mt-4 fw-bold ">منتجات قد تعجبك


        </h3>
        <div class="slider" dir="ltr">
            @foreach ($product->similarProducts() as $item)
                <a href="{{ route('single_product', $item->id) }}" class="text-decoration-none">
                    <div class="product">


                        <div class="product-entry__image mb-2">
                            <img loading="lazy" src="{{ asset($item->getImageUrl()) }}" class="d-block m-auto "
                                style="object-fit:contain;width:100%;" alt="{{ $item->name }}">

                        </div>
                        <div class="container position-relative">
                            <p class="productName my-0 mt-2 mb-1"> {{ $item->name }} </p>

                            <span class="text-danger pricewithout fw-bold fs-6 fs-lg-5">
                                {{ $item->discount == 0 ? $item->price : $item->price - $item->discount }}
                            </span>
                            <span class="text-danger fw-bold fs-6 fs-lg-5">
                                {{ get_general_value('currancy') }}
                            </span>

                            @if ($item->discount != 0)
                                <span class="text-decoration-line-through text-secondary ms-2">
                                    {{ $item->price }} {{ get_general_value('currancy') }}
                                </span>
                            @endif
                            <div>
                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="qnt" value="1" id="">
                                    <input type="hidden" name="product_id" value="{{ $item->id }}" id="">

                                    <div class="d-flex align-items-center gap-2">
                                        <button type="submit" name="addCart" class="btn btn-sm btn-pro loveBtn">
                                            <img loading="lazy" src="{{ asset('front/assets/image/icons/heart.png') }}"
                                                width="20" height="21" alt="">
                                        </button>
                                        <button type="submit" name="addCart" class="btn btn-sm btn-pro addTCartBtn">
                                            إضافة للسلة
                                        </button>


                                    </div>

                                </form>
                            </div>


                        </div>


                    </div>
                </a>
            @endforeach


        </div>
    </section>
@endsection
