<div class="mt-4 pb-2" style="background-color: #f9fafb;padding-top:60px;">
    <style>
        .half-star {
            display: inline-block;
            position: relative;
            color: gold;
            overflow: hidden;
            width: 10px;
            /* نصف الحجم */
        }

        .half-star::after {
            content: '☆';
            position: absolute;
            left: 0;
            width: 100%;
            color: lightgray;
        }
    </style>

    <div class="container">
        <div class="d-flex align-items-center mb-1">
            <h5 class="text-center my-md-2 my-3 mainColor fw-bolder fs-4">آراء العملاء</h5>
        </div>

        <div class="my-4">
            <div class="comment">

                @foreach (App\Models\Comment::where('product_id', null)->orderby('id', 'desc')->get() as $item)
                    @foreach (App\Models\Comment::where('product_id', null)->orderBy('id', 'desc')->get() as $item)
                        <div class="px-3 mb-4 position-relative">
                            <div class="p-3 border shadow rounded comment-item position-relative">
                                {{-- أيقونة الاقتباس --}}
                                <div class="quote position-absolute" style="top: -24px; right: 20px;">
                                    <i class="fa-solid fa-quote-right fa-2x m-2"></i>
                                </div>

                                {{-- عرض النجوم ديناميكيًا --}}
                                @php
                                    $fullStars = floor($item->stars);
                                    $halfStar = $item->stars - $fullStars >= 0.5;
                                    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                @endphp

                                <div class="rating-stars" style="font-size: 20px; color: gold;">
                                    {{-- نجوم كاملة --}}
                                    @for ($i = 0; $i < $fullStars; $i++)
                                        <span><i class="fas fa-star"></i></span>
                                    @endfor

                                    {{-- نصف نجمة باستخدام CSS --}}
                                    @if ($halfStar)
                                        <span><i class="fas fa-star-half-stroke"></i></span>
                                    @endif

                                    {{-- نجوم فارغة --}}

                                </div>

                                {{-- نص التعليق --}}
                                <div class="mb-4" style="font-size: 14px;">
                                    {{ $item->comment }}
                                </div>

                                {{-- اسم الكاتب والصورة --}}
                                <div class="d-flex align-items-center mt-4 position-absolute" style="bottom: 20px;">
                                    <img loading="lazy" src="{{ asset('front/assets/image/icons/profile.png') }}"
                                        class="me-2" width="40" height="40" alt="">
                                    <h3 class="" style="font-size: 14px;">{{ $item->name }}</h3>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach



            </div>

        </div>
    </div>

</div>
