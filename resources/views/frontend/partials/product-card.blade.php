<a href="{{ route('single_product', $item->id) }}" class="text-decoration-none h-100">
    <div class="product h-100">
        <div class="product-entry__image mb-2">
            <img loading="lazy" src="{{ asset($item->getImageUrl()) }}" 
                 class="d-block m-auto w-100" 
                 style="object-fit:contain;height:200px;" 
                 alt="{{ $item->name }}">
        </div>
        <div class="container position-relative d-flex flex-column h-100">
            <div>
                <p class="productName my-0 mt-2 mb-1 text-truncate" style="max-width: 100%;"> 
                    {{ $item->name }} 
                </p>
                <div class="mb-2">
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
                </div>
            </div>
            <div class="mt-auto">
                <form action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="qnt" value="1">
                    <input type="hidden" name="product_id" value="{{ $item->id }}">
                    <div class="d-flex align-items-center gap-2">
                        <button type="submit" name="addCart" class="btn btn-sm btn-pro addTCartBtn flex-grow-1">
                            إضافة للسلة
                        </button>
                        <button type="submit" name="addCart" class="btn btn-sm btn-pro loveBtn">
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