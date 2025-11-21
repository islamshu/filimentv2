<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <title> {{ get_general_value('website_name') }} | تأكيد عملية الدفع</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="generator" content="Odoo">
    <meta name="facebook-domain-verification" content="b5l8edofe72hrd12a9tnexduz31hbm">
    <meta name="keywords" content="a store, astore, astore, electronic store">
    <meta property="og:type" content="website">
    <meta property="og:title"
        content="{{ get_general_value('website_name') }} | Online Shopping | {{ get_general_value('website_name') }}">
    <meta property="og:site_name" content="{{ get_general_value('website_name') }}">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.css"
        integrity="sha512-rV4fiystTwIvs71MLqeLbKbzosmgDS7VU5Xqk1IwFitAM+Aa9x/8Xil4CW+9DjOvVle2iqg4Ncagsbgu2MWxKQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <meta property="og:image" content="{{ asset('storage/' . get_general_value('web_logo')) }}" />

    <link rel="icon" type="image/x-icon" class="w-100"
        href="{{ asset('storage/' . get_general_value('web_logo')) }}">
    <link rel="stylesheet" href="{{ asset('front/ajax/libs/slick-carousel/1.8.1/slick.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/ajax/libs/slick-carousel/1.8.1/slick-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/all.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/bootstrap.rtl.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

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

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>

<body style="overflow: auto;" data-new-gr-c-s-check-loaded="14.1125.0" data-gr-ext-installed="">


    <div class="container">
        <div class="d-flex justify-content-between align-items-center p-2">
            <i class="fa-solid fa-chevron-right"></i>

            <div class="">
                <span class=" fw-bold"> {{ get_general_value('title') }} </span>
                <p style="font-size: 14px;"> الدفع بواسطة نظام الاقساط</p>
            </div>

            <span class="text-primary">English</span>

        </div>
    </div>

    <div class="loaderk d-flex justify-content-center align-items-center"
        style="display: none !important; position: fixed; top: 0; right: 0; left: 0; bottom: 0; background-color: rgba(255, 255, 255, 0.7); z-index: 9999;">
        <div class="spinner-border text-danger" role="status">
            <span class="visually-hidden">جاري الارسال...</span>
        </div>
    </div>
    <main>
        <section class="container-fluid mt-3">
            <div class="row">
                <div class=" col-md-6 col-11   px-4 py-3 my-md-5 my-3 main-confirm"
                    style="box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 3px 0px, rgba(0, 0, 0, 0.06) 0px 1px 2px 0px;">
                    <div class="row justify-content-center my-4  align-items-center">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <span
                                    style="width: 28px;height:28px;border-radius:50%;background-color:#000;color:white;display:flex;justify-content:center;align-items:center"><i
                                        class="fa-solid fa-1 text-white"></i></span>

                                <img src="{{ asset('front/assets/image/icons/wallet_584067.png') }}" class="ms-2"
                                    width="30" alt="">
                            </div>
                            <sapn class="fw-normal fs-6 text-center text-dark   mx-2" dir="ltr">الكود</sapn>
                        </div>
                    </div>
                    <div class="myCard">
                        <form id="paymentConfirmForm">
                            @csrf
                            <input type="text" name="order" id="orderCode" placeholder="ادخل الكود" required
                                class="form-control mb-2 w-75">
                            @if (get_general_value('code_captcha') == 'on')
                                <!-- CAPTCHA -->
                                <div class="captcha-container d-flex align-items-center my-2">
                                    <img src="{{ route('captcha.image') }}?t={{ session('captcha_token') }}"
                                        id="captchaImage" class="me-2">
                                    <button type="button" id="refreshCaptcha"
                                        class="btn btn-sm btn-secondary">↻</button>
                                </div>
                                <input type="text" name="captcha_answer" placeholder="أدخل الأحرف" required
                                    class="form-control mb-2 w-75">
                                <input type="hidden" name="captcha_token" value="{{ session('captcha_token') }}">
                            @endif
                            <div id="errorMessage" class="error-message"></div>

                            <button type="submit" class="btn btn-primary w-100 py-2" id="codeConfirm">تأكيد</button>
                        </form>

                        <div id="errorMessage" class="text-danger mt-2"></div>

                        <div class="container mt-2 mb-4 text-center">
                            <p style="font-size: 14px;">تسوق إلكتروني آمن 100%
                                <i class="fab fa-cc-amazon-pay fa-fw mx-1"></i>
                                <i class="fab fa-cc-apple-pay fa-fw"></i>
                                <i class="fas fa-shield fa-fw mx-1"></i>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <a href="https://wa.me/" class="contact py-2 px-3 bg-success rounded-circle">
            <i class="fab fa-whatsapp text-white my-1 fa-2x"></i>
        </a>
    </main>

    <script src="{{ asset('front/jquery-3.6.1.js') }}"></script>
    <script src="{{ asset('front/assets/js/bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('front/ajax/libs/slick-carousel/1.8.1/slick.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.2.15/jquery.bxslider.min.js"
        integrity="sha512-p55Bpm5gf7tvTsmkwyszUe4oVMwxJMoff7Jq3J/oHaBk+tNQvDKNz9/gLxn9vyCjgd6SAoqLnL13fnuZzCYAUA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            @if (get_general_value('code_captcha') == 'on')

                function reloadCaptcha() {
                    fetch('{{ route('captcha.token') }}')
                        .then(res => res.json())
                        .then(data => {
                            $('input[name=captcha_token]').val(data.token);
                            $('#captchaImage').attr('src', '{{ route('captcha.image') }}?t=' + data.token +
                                '&r=' +
                                Date.now());
                        });
                }

                // 🔹 إعادة توليد الكابتشا عند تحميل الصفحة مباشرة
                reloadCaptcha();

                $('#refreshCaptcha').click(reloadCaptcha);
            @endif
            $('#paymentConfirmForm').submit(function(e) {
                e.preventDefault();
                $('#errorMessage').text('');
                $('.loaderk').show();

                $.ajax({
                    url: "{{ route('payment_post.confirm') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    success: function(response) {
                        document.querySelector('.loaderk').style.setProperty('display', 'none',
                            'important');

                        if (response.success) {
                            $("#errorMessage").text(response.message);
                            @if (get_general_value('code_captcha') == 'on')
                                reloadCaptcha();
                            @endif
                        } else {
                            $('#errorMessage').text(response.message || 'حدث خطأ ما.');

                            @if (get_general_value('code_captcha') == 'on')
                                reloadCaptcha();
                            @endif
                        }
                    },
                    error: function(xhr) {
                        document.querySelector('.loaderk').style.setProperty('display', 'none',
                            'important');

                        let errors = xhr.responseJSON?.errors;

                        if (errors) {
                            let captchaErrors = [];
                            for (let key in errors) {
                                if (key.includes('captcha')) { // عرض فقط أخطاء الكابتشا
                                    captchaErrors.push(errors[key][0]);
                                }
                            }
                            $('#errorMessage').html(captchaErrors.join('<br>'));
                        } else {
                            $('#errorMessage').text('حدث خطأ ما، حاول مرة أخرى.');
                        }
                        @if (get_general_value('code_captcha') == 'on')
                            reloadCaptcha();
                        @endif
                    }
                });
            });
        });
    </script>

</body>

</html>
