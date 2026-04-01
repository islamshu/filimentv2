<footer class=" mt-3" style="padding-top: 50px;">

    <div class="container text-dark fw-bold">
        <div class="row">

            <div class="col-lg-3 col-md-4 col-12 mb-3">
                <div class="d-flex  justify-content-start w-100 py-3">
                    <a href="index-2.html">
                        <img loading="lazy" class="ms-auto me-auto" src="{{ asset('storage/'.get_general_value('web_logo')) }}"
                            width="180" alt="">
                    </a>
                </div>

                <!-- <h5 class="pb-3 text-center mb-3" style="color: #00395e;">من نحن</h5> -->
                {!!get_general_value('about_us')!!}
            </div>


            <div class="col-lg-3 col-md-4 col-12 mb-3">
                <div class="w-100">
                    <h5 class="pb-3 text-start mb-3" style="color: #00395e;">روابط مهمة</h5>
                    <div class="container text-start" style="font-size: 12px;">
                        <div class="mb-3">
                            <i class="fa-solid fa-angles-left"></i> <a class="text-decoration-none mainColor"
                                href="{{route('page','term')}}">سياسة الخصوصية والشروط والاحكام</a>
                        </div>
                        <div class="mb-3">
                            <i class="fa-solid fa-angles-left"></i> <a class="text-decoration-none mainColor"
                                href="{{route('page','pay')}}">طرق الدفع والأقساط</a>
                        </div>

                        <div class="mb-3">
                            <i class="fa-solid fa-angles-left"></i> <a class="text-decoration-none mainColor"
                                href="{{route('page','ship')}}">الشحن والتوصيل</a>
                        </div>

                        <div class="mb-3">
                            <i class="fa-solid fa-angles-left"></i> <a class="text-decoration-none mainColor"
                                href="{{route('page','confirm')}}">ألية الضمان</a>
                        </div>

                        <div class="mb-3">
                            <i class="fa-solid fa-angles-left"></i> <a class="text-decoration-none mainColor"
                                href="{{route('page','return')}}">شروط و سياسة الاستبدال
                                والاسترجاع</a>
                        </div>
                        <div class="mb-3">
                            <i class="fa-solid fa-angles-left"></i> <a class="text-decoration-none mainColor"
                                href="ContactUs.html">تواصل معنا
                            </a>
                        </div>
                        <div class="mb-3">
                            <i class="fa-solid fa-angles-left"></i> <a class="text-decoration-none mainColor"
                                href="{{route('page','safe')}}">خدمة الحماية الشاملة
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-12 mb-3">
                <h5 class="pb-3 text-start mb-3" style="color: #00395e;">تواصل معنا</h5>

                <div class="d-flex align-items-center mb-2">
                    <i class="fa-brands fa-whatsapp me-2" style="color: gray;width:20px;"></i>
                    <span class="fw-normal">{{get_general_value('whatsapp')}}</span>
                </div>

                <!-- <div class="d-flex align-items-center mb-2">
                <i class="fa-solid fa-mobile-screen me-2" style="color: gray;width:20px"></i>
                <span class="fw-normal">966582010097</span>
            </div> -->


                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-phone me-2" style="color: gray;width:20px"></i>
                    <span class="fw-normal">{{get_general_value('phone')}}</span>
                </div>


                <div class="d-flex align-items-center mb-2">
                    <i class="fa-solid fa-envelope me-2" style="color: gray;width:20px"></i>
                    <span class="fw-normal">{{get_general_value('email')}}</span>
                </div>


            </div>
            <div class="col-lg-3 col-md-4 col-12 mb-5">
                <div class="w-100 text-secondary">
                    <h5 class="pb-3 text-start mb-4" style="color: #00395e;">تابعنا على</h5>
                    <div class="d-flex">
            
                        @php
                            $socials = [
                                'instagram' => 'fab fa-instagram',
                                'twitter'   => 'fab fa-twitter',
                                'snapchat'  => 'fab fa-snapchat',
                                'tiktok'    => 'fab fa-tiktok',
                                'youtube'   => 'fab fa-youtube',
                                'facebook'  => 'fab fa-facebook',
                            ];
                        @endphp
            
                        @foreach ($socials as $key => $icon)
                            @php
                                $link = get_general_value($key);
                            @endphp
                            @if ($link)
                                <span style="border-radius: 50%; border: 1px solid gray; padding: 5px; display:flex; justify-content:center; align-items:center; margin:3px; width: 45px; height: 45px; line-height: 32px;">
                                    <a class="text-black-50" href="{{ $link }}" target="_blank">
                                        <i class="{{ $icon }} fa-fw fa-xl"></i>
                                    </a>
                                </span>
                            @endif
                        @endforeach
            
                    </div>
                </div>
            </div>
            
           
        </div>
    </div>
    <div style="background-color: #d31212; color:white;">
        <div class="container-fluid text-white py-3 px-3" style="font-size: 14px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-12 text-sm-center d-none d-lg-block">
                        الحقوق محفوظة | {{ get_general_value('website_name') }}-{{ now()->format('Y') }} </div>
                    <div
                        class="col-md-6 col-12  d-flex text-center align-items-center justify-content-center justify-content-lg-end ">
                        <span style="font-size: 13px; " class="me-2 d-none d-lg-block">الرقم الضريبي :
                            {{ get_general_value('number_dareba') }}</span>
                        @foreach (App\Models\Paymentimage::get() as $item)
                            <a href="{{$item->link}}" target="_blank" class="me-1">
                                <span class="me-1"
                                    style="width:55px;height:30px; background-color: white;padding:2px 10px;border-radius:4px;display:flex;justify-content:center;align-items:center;">
                                    <img loading="lazy" src="{{ $item->getImageUrl() }}"
                                        width="35" height="20" alt="{{ $item->title }}">
                                </span>
                            </a>
                        @endforeach

                    </div>
                    <span style="font-size: 13px; " class="me-2 fs d-block d-lg-none mb-3 mt-2">الرقم الضريبي :
                        {{ get_general_value('number_dareba') }}</span>
                    <div class="col-md-6 col-12 text-center d-block d-lg-none">
                        الحقوق محفوظة | {{ get_general_value('website_name') }}-{{ now()->format('Y') }} </div>

                </div>
            </div>
        </div>
</footer>
<a href="https://wa.me/{{ get_general_value('whatsapp') }}" class="contact py-2 px-3 bg-success rounded-circle">
    <i class="fab fa-whatsapp text-white my-1 fa-2x"></i>
</a>
<script src="{{ asset('front/jquery-3.6.1.js') }}"></script>
<script src="{{ asset('front/assets/js/bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('front/ajax/libs/slick-carousel/1.8.1/slick.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bxslider@4.2.15/dist/jquery.bxslider.min.js"></script>

<script src="{{ asset('front/cdn.jsdelivr.net/npm/swiper%4011/swiper-bundle.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
@yield('scripts')
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success_add'))
            Swal.fire({
                text: "{{ session('success_add') }}",
                icon: 'success',
                confirmButtonText: 'موافق',
                showCancelButton: true,
                cancelButtonText: 'الذهاب إلى السلة',
            }).then((result) => {
                if (result.isConfirmed) {
                    // تأكيد العملية
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // توجيه المستخدم إلى صفحة السلة
                    window.location.href = "{{ route('cart.index') }}";
                }
            });
        @endif
      
    });
</script>
<script type="text/javascript">
    // Update the cart count in real time (if needed)
    function updateCartCount() {
        let cartCount = {{ count(session('cart', [])) }};
        document.querySelector('.badge').textContent = cartCount;
    }
</script>



<script>
    var swiper = new Swiper(".mySwiper", {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
    });
    var swiper2 = new Swiper(".mySwiper2", {
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiper,
        },
    });




    document.addEventListener("DOMContentLoaded", function() {
        // Get all dropdown toggles
        var dropdownToggles = document.querySelectorAll('[data-bs-toggle="dropdown"]');

        // Loop through each dropdown toggle
        dropdownToggles.forEach(function(toggle) {
            var dropdownMenu = toggle.nextElementSibling;

            // Add event listeners for hover on toggle and menu
            toggle.addEventListener('mouseenter', function() {
                if (!dropdownMenu.classList.contains('show')) {
                    dropdownMenu.classList.add('show');
                    this.setAttribute('aria-expanded', 'true');
                }
            });

            dropdownMenu.addEventListener('mouseenter', function() {
                if (!dropdownMenu.classList.contains('show')) {
                    dropdownMenu.classList.add('show');
                    toggle.setAttribute('aria-expanded', 'true');
                }
            });

            // Close dropdown on mouse leave
            toggle.addEventListener('mouseleave', function() {
                if (dropdownMenu.classList.contains('show')) {
                    dropdownMenu.classList.remove('show');
                    this.setAttribute('aria-expanded', 'false');
                }
            });

            dropdownMenu.addEventListener('mouseleave', function() {
                if (dropdownMenu.classList.contains('show')) {
                    dropdownMenu.classList.remove('show');
                    toggle.setAttribute('aria-expanded', 'false');
                }
            });
        });
    });



    $(document).ready(function() {





        $('.slick-carousel').slick({
            dots: true,
            infinite: true,
            speed: 200,
            slidesToShow: 4,
            slidesToScroll: 1,
            arrows: true,
            rtl: true,
            autoplay: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                }, {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },

            ]
        });


        $('.comment').slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 3,
            slidesToScroll: 1,
            rtl: true,
            autoplay: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                }, {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }, {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });


       
        $('.loaderk').fadeOut(70, function() {

            $('.loaderk').css('height', '0px');
            $('.loaderk img').css('width', '0px');
        })
        $('body').css('overflow', 'auto');
        $('.slider').slick({
            dots: false,
            infinite: true,
            speed: 300,
            slidesToShow: 6,
            slidesToScroll: 1,
            autoplay: true,
            arrows: false,

            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                }, {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                }, {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });


    })
</script>
<script>
    var swiper = new Swiper(".mySwiper", {
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
</script>
<script>
$(document).ready(function() {
    let isLoading = false;
    
    function loadMoreProducts(button) {
        if (isLoading) return;
        
        const categoryId = button.data('category-id');
        let offset = button.data('offset');
        const total = button.data('total');
        
        if (offset >= total) {
            button.hide();
            return;
        }
        
        isLoading = true;
        
        button.prop('disabled', true).text('جاري التحميل...');
        
        $.ajax({
            url: '{{ route("load.more.products") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                category_id: categoryId,
                offset: offset,
                limit: 9,
                country_id: '{{ session('country_id') }}'
            },
            success: function(response) {
                if (response.html) {
                    // إضافة المنتجات الجديدة داخل نفس الـ container
                    $('#products-container-' + categoryId).append(response.html);
                    
                    const newOffset = offset + 9;
                    button.data('offset', newOffset);
                    const remaining = total - newOffset;
                    
                    if (remaining > 0) {
                        button.prop('disabled', false).text(`تحميل المزيد (${remaining} منتجات متبقية)`);
                    } else {
                        button.hide();
                    }
                    
                    // إعادة تهيئة أي مكتبات إضافية إذا كانت موجودة
                    // مثلاً إذا كنت تستخدم lazy load للصور
                    if (typeof lazyLoadImages === 'function') {
                        lazyLoadImages();
                    }
                }
                isLoading = false;
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                button.prop('disabled', false).text('حدث خطأ، حاول مرة أخرى');
                setTimeout(() => {
                    button.text('تحميل المزيد');
                    isLoading = false;
                }, 2000);
            }
        });
    }
    
    // استخدام Intersection Observer للتحميل التلقائي
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !isLoading) {
                    const button = $(entry.target);
                    if (button.is(':visible') && !button.prop('disabled')) {
                        loadMoreProducts(button);
                    }
                }
            });
        }, { 
            threshold: 0.1,
            rootMargin: '100px'
        });
        
        $('.load-more-btn').each(function() {
            observer.observe(this);
        });
    } else {
        $(window).on('scroll', function() {
            $('.load-more-btn:visible').each(function() {
                const button = $(this);
                const rect = button[0].getBoundingClientRect();
                const windowHeight = window.innerHeight || document.documentElement.clientHeight;
                
                if (rect.top <= windowHeight - 100 && !button.prop('disabled') && !isLoading) {
                    loadMoreProducts(button);
                }
            });
        });
        
        setTimeout(() => {
            $('.load-more-btn:visible').each(function() {
                const button = $(this);
                const rect = button[0].getBoundingClientRect();
                const windowHeight = window.innerHeight || document.documentElement.clientHeight;
                
                if (rect.top <= windowHeight - 100 && !button.prop('disabled') && !isLoading) {
                    loadMoreProducts(button);
                }
            });
        }, 1000);
    }
});
</script>
</body>


<!-- Mirrored from albayader-uae.store/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 22 Apr 2025 15:31:19 GMT -->

</html>
