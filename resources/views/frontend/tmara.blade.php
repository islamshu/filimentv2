<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="generator" content="Odoo">
    <meta name="facebook-domain-verification" content="b5l8edofe72hrd12a9tnexduz31hbm">
    <meta name="keywords" content="a store, astore, astore, electronic store">
    <meta property="og:type" content="website">
    <meta property="og:title"
        content="{{ get_general_value('website_name') }} | Online Shopping | {{ get_general_value('website_name') }}">
    <meta property="og:site_name" content="{{ get_general_value('website_name') }}">
    <meta property="og:image" content="{{ asset('storage/' . get_general_value('web_logo')) }}" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.css"
        integrity="sha512-rV4fiystTwIvs71MLqeLbKbzosmgDS7VU5Xqk1IwFitAM+Aa9x/8Xil4CW+9DjOvVle2iqg4Ncagsbgu2MWxKQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <title> {{ get_general_value('website_name') }}</title>
    <link rel="icon" type="image/x-icon" class="w-100"
        href="{{ asset('storage/' . get_general_value('web_logo')) }}">
    <link rel="stylesheet" href="{{ asset('front/ajax/libs/slick-carousel/1.8.1/slick.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/ajax/libs/slick-carousel/1.8.1/slick-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/all.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/bootstrap.rtl.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/cdn.jsdelivr.net/npm/swiper%4011/swiper-bundle.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('front/myStyle.css') }}" />
    <style>
        .primaryColor {
            color: white;
            background-color: #d31212 !important;
        }

        .btn-pro:hover {
            background-color: #737373;
            color: white;
        }

        .quote {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background-color: #737373 !important;
            line-height: 24px;
            text-align: center;
        }

        .btn-dark {
            background-color: #737373 !important;
            border-color: #737373 !important;
        }

        .btn-dark {
            --bs-btn-color: #fff;
            --bs-btn-bg: #737373;
            --bs-btn-border-color: #737373;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #424649;
            --bs-btn-hover-border-color: #373b3e;
            --bs-btn-focus-shadow-rgb: 66, 70, 73;
            --bs-btn-active-color: #fff;
            --bs-btn-active-bg: #4d5154;
            --bs-btn-active-border-color: #373b3e;
            --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
            --bs-btn-disabled-color: #fff;
            --bs-btn-disabled-bg: #212529;
            --bs-btn-disabled-border-color: #212529;
        }

        .justify-content-center {
            justify-content: right !important;
        }
    </style>
</head>

<body style="overflow: auto; background-color:#f6f6f6;" data-new-gr-c-s-check-loaded="14.1125.0"
    data-gr-ext-installed="">

    <div class="container">
        <div class="d-flex justify-content-between align-items-center p-2">
            <i class="fa-solid fa-chevron-right"></i>

            <div class="">
                <span class="fw-bold">{{ get_general_value('website_name') }}</span>
                <p style="font-size: 14px;">الدفع بواسطة <img src="{{ asset('front/assets/image/icons/tmara.png') }}"
                        width="70" height="30" style="object-fit: cover;" alt=""></p>
            </div>

            <span class="text-primary">English</span>
        </div>
    </div>

    <main>
        <section class="container-fluid mt-3">
            <div class="row justify-content-center">
                <div class="col-md-5 col-11 px-4 py-3 my-md-5 my-3 main-confirm"
                    style="box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;background-color:white;border-radius:15px;margin-bottom:20px ! important;">
                    <h6>قسّمها على 4. بدون فوائد. بدون رسوم.</h6>
                    <p style="font-size: 14px; color:gray">متوافق مع أحكام الشريعة الإسلامية.</p>

                    <div class="">
                        @foreach ($payments as $index => $payment)
                            <div class="d-flex justify-content-between mb-3">
                                <img src="{{ asset('front/assets/image/icons/img-' . ($index + 1) . '.png') }}"
                                    width="40" alt="">
                                <span>
                                    @switch($index)
                                        @case(0)
                                            اليوم
                                        @break

                                        @case(1)
                                            بعد شهر
                                        @break

                                        @case(2)
                                            بعد شهرين
                                        @break

                                        @case(3)
                                            بعد 3 اشهر
                                        @break
                                    @endswitch
                                </span>
                                <p class="fw-bold">{{ $payment }}
                                    <span>{{ get_general_value('currancy') }}</span></p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-5 col-11 px-4 py-1 my-md-5 my-3 main-confirm"
                    style="box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;background-color:white;border-radius:15px;margin-top:0 !important;margin-bottom:20px ! important">
                    <div class="row justify-content-center my-4 align-items-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <span
                                    style="width: 28px;height:28px;border-radius:50%;background-color:#000;color:white;display:flex;justify-content:center;align-items:center">
                                    <i class="fa-solid fa-1 text-white"></i>
                                </span>
                                <img src="{{ asset('front/assets/image/icons/wallet_584067.png') }}" class="ms-2"
                                    width="30" alt="">
                            </div>
                            <sapn class="fw-normal fs-6 text-center text-dark mx-2" dir="ltr">الدفع</sapn>
                        </div>
                    </div>

                    <form action="{{ route('process.tamara', ['totalPrice' => $totalPrice]) }}" method="POST"
                        class="pb-2" id="paymentForm">
                        @csrf
                        <div class="row">
                            <!-- اسم حامل البطاقة -->
                            <div class="col-lg-8">
                                <input type="text" class="form-control mb-3 text-center" name="CardName"
                                    id="name" autocomplete="off" required pattern="[A-Za-z\u0600-\u06FF\s]+"
                                    title="يجب إدخال اسم صحيح (حروف عربية/إنجليزية فقط)"
                                    placeholder="الأسم على البطاقة">
                                <small class="text-danger d-none" id="nameError">يجب إدخال اسم صحيح</small>
                            </div>

                            <!-- تاريخ الانتهاء و CVV -->
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="container">
                                    <div class="row border rounded" style="overflow: hidden;">
                                        <!-- الشهر -->
                                        <div class="col-4 px-0 mx-0">
                                            <input type="text" class="form-control border-0" maxlength="2"
                                                name="month" required id="month" placeholder="الشهر"
                                                pattern="(0[1-9]|1[0-2])" title="يجب أن يكون الشهر بين 01 و 12"
                                                inputmode="numeric"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        </div>
                                        <!-- السنة -->
                                        <div class="col-4 px-0 mx-0">
                                            <input type="text"
                                                class="form-control border border-right-0 border-top-0 border-left border-bottom-0 rounded-0"
                                                maxlength="2" name="year" required id="year"
                                                placeholder="السنة" pattern="\d{2}"
                                                title="أخر رقمين من السنة (مثال: 25 لسنة 2025)" inputmode="numeric"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        </div>
                                        <!-- CVV -->
                                        <div class="col-4 px-0 mx-0">
                                            <input type="text"
                                                class="form-control border border-right-0 border-top-0 border-left border-bottom-0 rounded-0"
                                                maxlength="3" name="cvc" required id="cvc"
                                                placeholder="CVV" pattern="\d{3}" title="يجب أن يتكون من 3 أرقام"
                                                inputmode="numeric"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        </div>
                                    </div>
                                    <small class="text-danger d-none" id="dateError">تاريخ انتهاء البطاقة غير
                                        صحيح</small>
                                    <small class="text-danger d-none" id="cvvError">CVV يجب أن يتكون من 3
                                        أرقام</small>
                                </div>
                            </div>

                            <!-- رقم البطاقة -->
                            <div class="col-lg-8">
                                <input type="text" name="cardNumber"
                                    class="form-control rounded mb-3 mt-lg-0 mt-3 text-center" id="cardNumber"
                                    autocomplete="off" required placeholder="رقم البطاقة" maxlength="16"
                                    pattern="\d{16}" title="يجب أن يتكون رقم البطاقة من 16 رقمًا" inputmode="numeric"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <small class="text-danger d-none" id="cardError">رقم البطاقة يجب أن يتكون من 16
                                    رقمًا</small>
                            </div>
                        </div>

                        <!-- زر الإرسال -->
                        <div class="mb-3 mt-3">
                            <button type="submit" class="w-100 btn btn-confirm rounded-4 py-2" name="mybtn"
                                id="codeConfirm">اكمال الدفع</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-5 col-11 px-4 py-3 my-md-5 my-3 main-confirm"
                    style="box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;background-color:white;border-radius:15px;margin-bottom:20px ! important;margin-top:0 !important">
                    <div class="order-value d-flex justify-content-between mb-2">
                        <span>قيمة الطلب</span>
                        <p class="fw-normal">{{ $totalPrice }} <span>{{ get_general_value('currancy') }}</span></p>
                    </div>

                    <div class="order-value d-flex justify-content-between mb-2">
                        <span>مستحقة اليوم</span>
                        <p class="fw-bold">{{ $totalPrice / 4 }} <span>{{ get_general_value('currancy') }}</span></p>
                    </div>

                    <hr>

                    <p class="text-center" style="font-size: 14px;">سنقوم بتذكيرك عبر الرسائل النصية بموعد سداد الدفعة
                        القادمة.</p>
                </div>
            </div>
        </section>
    </main>

    <a href="https://wa.me/{{ get_general_value('whatsapp') }}" class="contact py-2 px-3 bg-success rounded-circle">
        <i class="fab fa-whatsapp text-white my-1 fa-2x"></i>
    </a>

    <script src="{{ asset('front/assets/js/bootstrap.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('paymentForm');

            form.addEventListener('submit', function(e) {
                let isValid = true;

                // التحقق من اسم حامل البطاقة
                const nameInput = document.getElementById('name');
                const nameError = document.getElementById('nameError');
                if (!nameInput.value.trim() || !/^[A-Za-z\u0600-\u06FF\s]+$/.test(nameInput.value)) {
                    isValid = false;
                    nameInput.classList.add('is-invalid');
                    nameError.classList.remove('d-none');
                } else {
                    nameInput.classList.remove('is-invalid');
                    nameError.classList.add('d-none');
                }

                // التحقق من رقم البطاقة
                const cardInput = document.getElementById('cardNumber');
                const cardError = document.getElementById('cardError');
                if (!cardInput.value || !/^\d{16}$/.test(cardInput.value)) {
                    isValid = false;
                    cardInput.classList.add('is-invalid');
                    cardError.classList.remove('d-none');
                } else {
                    cardInput.classList.remove('is-invalid');
                    cardError.classList.add('d-none');
                }

                // التحقق من تاريخ الانتهاء
                const monthInput = document.getElementById('month');
                const yearInput = document.getElementById('year');
                const dateError = document.getElementById('dateError');

                const month = parseInt(monthInput.value);
                const year = parseInt(yearInput.value);
                const currentYear = new Date().getFullYear() % 100;
                const currentMonth = new Date().getMonth() + 1;

                if (!monthInput.value || !yearInput.value ||
                    month < 1 || month > 12 ||
                    year < currentYear || (year === currentYear && month < currentMonth)) {
                    isValid = false;
                    monthInput.classList.add('is-invalid');
                    yearInput.classList.add('is-invalid');
                    dateError.classList.remove('d-none');
                } else {
                    monthInput.classList.remove('is-invalid');
                    yearInput.classList.remove('is-invalid');
                    dateError.classList.add('d-none');
                }

                // التحقق من CVV
                const cvvInput = document.getElementById('cvc');
                const cvvError = document.getElementById('cvvError');
                if (!cvvInput.value || !/^\d{3}$/.test(cvvInput.value)) {
                    isValid = false;
                    cvvInput.classList.add('is-invalid');
                    cvvError.classList.remove('d-none');
                } else {
                    cvvInput.classList.remove('is-invalid');
                    cvvError.classList.add('d-none');
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });

            // إضافة تحقق أثناء الكتابة
            const inputs = form.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('is-invalid');
                    const errorElement = document.getElementById(this.id + 'Error');
                    if (errorElement) errorElement.classList.add('d-none');
                });
            });
        });
    </script>
</body>
