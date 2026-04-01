@foreach ($subcategory as $category)
    <section class="mt-2 mb-3">
        <img loading="lazy" src="{{ asset($category->image) }}" class="w-100 subsub" alt="">
        <div class="container">
            <div class="d-flex align-items-center">
                <h5 class="text-center my-md-5 my-4 mainColor" style=""><span class="me-2">|</span>
                    {{ $category->name }}</h5>
                @if (!$isSingleCategory)
                    <a href="{{ route('category.slug', $category->slug) }}" class="btn btn-sm rounded-4 ms-auto"
                        style="margin-left:65px">عرض الكل <i class="fa-solid fa-arrow-left-long"></i></a>
                @endif
            </div>

           @if($isSingleCategory)
    {{-- عرض المنتجات بشكل عمودي مع تحميل تدريجي --}}
    <div class="products-grid" id="products-grid-{{ $category->id }}">
        <div class="row" id="products-container-{{ $category->id }}">
            @foreach ($category->initial_products as $item)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 product-item">
                    @include('frontend.partials.product-card', ['item' => $item])
                </div>
            @endforeach
        </div>
        
        @if($category->has_more_products)
            <div class="text-center mt-3">
                <button class="btn btn-primary load-more-btn" 
                        data-category-id="{{ $category->id }}"
                        data-offset="9"
                        data-total="{{ $category->total_products }}">
                    تحميل المزيد ({{ $category->total_products - 9 }} منتجات متبقية)
                </button>
            </div>
        @endif
    </div>
            @else
                {{-- عرض المنتجات في كاروسيل (العرض الأصلي) --}}
                <div class="slick-carousel">
                    @foreach ($category->products->sortByDesc('id')->take(6) as $item)
                        <div class="">
                            <a href="{{ route('single_product', $item->id) }}" class="text-decoration-none">
                                <div class="product">
                                    <div class="product-entry__image mb-2">
                                        <img loading="lazy" src="{{ asset($item->getImageUrl()) }}"
                                            class="d-block m-auto" style="object-fit:contain;width:100%;"
                                            alt="{{ $item->name }}">
                                    </div>
                                    <div class="container position-relative">
                                        <p class="productName my-0 mt-2 mb-1"> {{ $item->name }} </p>
                                        <span class="text-danger pricewithout fw-bold fs-6 fs-lg-5">
                                            {{ $item->discount == 0 ? $item->price : $item->price - $item->discount }}
                                        </span>
                                        <span class="text-danger fw-bold fs-6 fs-lg-5">
                                            {{ get_currancy() }}
                                        </span>
                                        @if ($item->discount != 0)
                                            <span class="text-decoration-line-through text-secondary ms-2">
                                                {{ $item->price }} {{ get_currancy() }}
                                            </span>
                                        @endif
                                        <div>
                                            <form action="{{ route('cart.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="qnt" value="1">
                                                <input type="hidden" name="product_id" value="{{ $item->id }}">
                                                <div class="d-flex align-items-center gap-2">
                                                    <button type="submit" name="addCart"
                                                        class="btn btn-sm btn-pro addTCartBtn">
                                                        إضافة للسلة
                                                    </button>
                                                    <button type="submit" name="addCart"
                                                        class="btn btn-sm btn-pro loveBtn">
                                                        <img loading="lazy"
                                                            src="{{ asset('front/assets/image/icons/heart.png') }}"
                                                            width="20" height="21" alt="">
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endforeach
