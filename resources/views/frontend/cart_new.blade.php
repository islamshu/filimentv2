@extends('layouts.frontend')
@section('title', 'السلة')
@section('styles')
    <style>
        .floating-box {
            position: fixed;
            bottom: 20px;
            left: 20px;
            color: white;
            background-color: #2c4fba;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            width: 200px;
        }

        .floating-box h5,
        .floating-box h6,
        .floating-box p {
            margin: 0;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .floating-box p {
            font-weight: bold;
        }

        .installment {
            display: none;
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

        .product-options {
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }

        .product-options h5 {
            font-size: 16px;
            margin-bottom: 20px;
            color: #121f41;
        }

        .product-options label {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
        }

        .product-options .form-control {
            height: 40px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 8px 12px;
            text-align: right;
            /* لجعل النصوص على اليمين */
        }

        .product-options .form-group {
            margin-bottom: 20px;
        }

        /* إزالة أي نمط خاص بالنقاط */
        .product-options ul.list--vertical {
            list-style: none;
            padding: 0;
            margin: 0;
        }
    </style>
@endsection

@section('content')
    <section class="mt-5 py-3" style="margin-bottom: 90px !important;">
    </section>

    @if (count($cart) == 0)
        <nav aria-label="breadcrumb" style="margin: 20px">
            <ol class="breadcrumb mt-4">
                <li class="breadcrumb-item text-info">
                    <a href="/" class="text-info text-decoration-none" style="font-size: 14px;">الرئيسية</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page" style="font-size: 14px;">سلة المشتريات</li>
            </ol>
        </nav>

        <div class="row my-2">
            <div class="col-md-12 my-2">
                <div class="container rounded bg-white p-5 text-center" style="color: #121f41;">
                    <div class="mt-3"
                        style="width:8rem;height:8rem;border-radius:50%;padding:10px;text-align:center;background-color:#f3f4f6;margin:auto;line-height:4rem">
                        <i class="fa-solid fa-bag-shopping" style="font-size: 50px;color:gray;margin-top:25px;"></i>
                    </div>
                    <div class="my-4 fs-5">
                        السلة فارغة
                    </div>
                    <div class="">
                        <a href="/" class="btn btn-outline-secondary">عودة للرئيسية</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <nav aria-label="breadcrumb" style="margin: 20px">
            <ol class="breadcrumb mt-4">
                <li class="breadcrumb-item text-info">
                    <a href="/" class="text-info text-decoration-none" style="font-size: 14px;">الرئيسية</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page" style="font-size: 14px;">سلة المشتريات</li>
            </ol>
        </nav>

        <section class="container mt-3">
            <div class="row my-2">
                <div class="col-md-12 my-2">
                    @foreach ($cart as $item)
                        @php $product = \App\Models\Product::find($item['id']); @endphp
                        <div class="container rounded border bg-white mb-3">
                            <div class="row align-items-center py-2">
                                <div class="col-4 col-md-3 col-lg-2">
                                    <div class="rounded border m-3">
                                        <img class="w-100 d-block mx-auto" src="{{ $product->getImageUrl() }}"
                                            alt="{{ $item['name'] }}">
                                    </div>
                                </div>
                                <div class="col-7 col-md-6 col-lg-4 mt-md-0 mt-3 px-0">
                                    <a href="{{ route('single_product', $product->id) }}"
                                        class="text-decoration-none h6 d-block text-dark text-start">
                                        {{ $product->name }}
                                    </a>
                                    <span class="text-black-50">{{ $product->price - $product->discount }}
                                        {{ get_currancy() }}</span>
                                </div>

                                <div class="col-12 col-md-3 col-lg-5 my-3 px-0">
                                    <div class="container">
                                        <div class="row align-items-center">
                                            <div class="col-8 col-md-7 ps-3 ps-lg-0">
                                                <form action="javascript:void(0);" method="POST"
                                                    class="row align-items-center justify-content-center justify-content-lg-start update-quantity-form">
                                                    @csrf
                                                    <input type="hidden" name="itemKey" value="{{ $item['id'] }}">
                                                    <button type="button" class="text-center form-control decrease-btn"
                                                        style="width: 40px;height:40px !important;">
                                                        <i class="fa fa-minus text-black-50" aria-hidden="true"></i>
                                                    </button>
                                                    <input type="number" class="text-center form-control quantity-input"
                                                        style="width: 50px;height:40px !important;"
                                                        value="{{ $item['quantity'] }}" name="quantity" min="1">
                                                    <button type="button" class="text-center form-control increase-btn"
                                                        style="width: 40px;height:40px !important;">
                                                        <i class="fa fa-plus text-black-50" aria-hidden="true"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="col-4 col-md-5 text-end fs-6 fw-bold total-price"
                                                data-item-key="{{ $item['id'] }}">
                                                المجموع: {{ $item['price'] * $item['quantity'] }}
                                                {{ get_currancy() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-1 col-md-1 mt-md-0 my-2 d-flex align-items-center justify-content-center">
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="itemKey" value="{{ $item['id'] }}">
                                        <button type="submit" style="background-color: transparent; border:none;">
                                            <i class="fa-solid fa-circle-xmark"
                                                style="color: #ff6a79;cursor:pointer;font-size:25px;"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="container mt-4 rounded bg-white border py-4">
                    <h5 class="fw-bold text-black mb-3">مجموع السلة</h5>
                    <div class="row">
                        <div class="col-6">الإجمالي:</div>
                        <div class="col-6 text-end fw-bold total_price">{{ $totalPrice }}
                            {{ get_currancy() }}</div>
                    </div>
                </div>
                @if (session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('send_data_new') }}" method="POST"
                    class="row align-items-center justify-content-center justify-content-lg-start">
                    @csrf
                    <div class="product-options mt-4 rounded bg-white border py-4 px-4">
                        <h5 class="fw-bold text-black mb-3">تفاصيل الطلب</h5>

                        <!-- الاسم -->
                        <div class="form-group mb-3">
                            <label class="product-option-name required">الاسم كاملا</label>
                            <input type="text" id="fullName" name="name" class="form-control"
                                placeholder="الاسم كاملا" required>
                        </div>

                        <!-- الايميل -->
                        {{-- <div class="form-group mb-3">
                            <label class="product-option-name required">الايميل</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="الايميل" required>
                        </div> --}}

                        <!-- رقم الواتس -->
                        <div class="form-group mb-3">
                            <label class="product-option-name required">رقم الواتس</label>
                            <input type="text" id="WhatsApp" name="whatsApp" class="form-control"
                                placeholder="رقم الواتس" required>
                        </div>

                        <!-- العنوان -->
                        <div class="form-group mb-3">
                            <label class="product-option-name required">العنوان كاملا</label>
                            <input type="text" id="address" name="address" class="form-control"
                                placeholder="العنوان كاملا" required>
                        </div>

                        <!-- طريقة الدفع -->
                        <div class="form-group mb-3">
                            <label class="product-option-name required">طريقة الدفع</label>
                            <select class="form-control" id="installment" name="payment_method" required>
                                <option value="" selected disabled>اختر</option>
                                <option value="all">كامل</option>
                                <option value="installment">تقسيط</option>
                                @if (get_general_value('tappy_tamara_payment') == 'on')
                                    <option value="tappy">تابي</option>
                                    <option value="tamara">تمارا</option>
                                @endif
                                @if (get_general_value('kent_payment') == 'on')
                                    <option value="k-net">كي نت</option>
                                @endif
                            </select>
                        </div>

                        @php
                            $paymentSettings = App\Models\PaymentSettings::first();
                            $isCustom = $paymentSettings?->custom_payment_enabled ?? false;
                            $isMultiple = $paymentSettings?->multiple_payments_enabled ?? false;
                            $multiple_payments = $paymentSettings?->multiple_payments ?? [];
                            $default_batch = $paymentSettings?->batch ?? 0;
                        @endphp

                        <!-- المجموع الكلي -->
                        <div class="form-group mb-3 installment">
                            <label class="product-option-name required">المجموع الكلي</label>
                            <input value="{{ $totalPrice }}" id="TotalPrice" name="TotalPrice" class="form-control"
                                type="number" readonly>
                        </div>

                        <!-- الدفعة الأولى -->
                        <div class="form-group mb-3 installment">
                            <label class="product-option-name required">الدفعة الأولى</label>
                            @if ($isCustom)
                                <input value="{{ $default_batch }}" min="0" readonly id="FirstPayment"
                                    name="FirstPayment" class="form-control" type="number">
                            @elseif ($isMultiple && count($multiple_payments) > 0)
                                <select id="FirstPaymentSelect" class="form-control">
                                    <option value="">اختر قيمة الدفعة</option>
                                    @foreach ($multiple_payments as $payment)
                                        <option value="{{ $payment }}">{{ $payment }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" id="FirstPayment" name="FirstPayment"
                                    value="{{ $default_batch }}">
                            @else
                                <p class="text-danger">لم يتم تفعيل نظام دفعات صالح.</p>
                            @endif
                        </div>

                        <!-- عدد أشهر التقسيط -->
                        <div class="form-group mb-3 installment">
                            <label class="product-option-name required">الرجاء تحديد عدد شهور التقسيط</label>
                            <select name="InstallmentBy" id="InstallmentBy" class="form-control">
                                @for ($i = 1; $i <= 24; $i++)
                                    <option value="{{ $i }}">{{ $i }} شهر</option>
                                @endfor
                            </select>
                        </div>

                        <!-- الدفعة الشهرية -->
                        <div class="form-group mb-3 installment" id="MonthlyPaymentLi" style="display:none;">
                            <label class="product-option-name required">الدفعة الشهرية</label>
                            <input value="0" readonly id="MonthlyPayment" name="MonthlyPayment"
                                class="form-control">
                        </div>

                        <!-- زر الإرسال -->
                        <div class="form-group text-end">
                            <button type="submit" class="btn btn-primary w-100">إتمام الطلب</button>
                        </div>

                    </div>
                </form>
                <div id="payContent" class="mt-4"></div>

            </div>
        </section>
        <div id="loader"
            style="
    display: none;
    position: fixed;
    top:0; left:0; right:0; bottom:0;
    background: rgba(255,255,255,0.8);
    z-index: 9999;
    text-align: center;
    padding-top: 20%;
    font-size: 20px;
    color: #121f41;">
            <i class="fa fa-spinner fa-spin fa-3x"></i>
            <p class="mt-3">جاري معالجة الطلب...</p>
        </div>

        <div class="floating-box">
            <h5>السعر الإجمالي</h5>
            <p id="floatingTotal">{{ $totalPrice }} {{ get_currancy() }}</p>
        </div>

        <a href="https://wa.me/{{ get_general_value('whatsapp') }}" class="contact p-1 rounded-circle text-center"
            style="background-color:#4dc247;width:50px;height:50px;">
            <i class="fab fa-whatsapp text-white my-1 fa-2x"></i>
        </a>
    @endif
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // عناصر الدفع
            const $installmentSelect = $('#installment');
            const $installmentFields = $('.installment');
            const $installmentBySelect = $('#InstallmentBy');
            const $firstPaymentInput = $('#FirstPayment');
            const $firstPaymentSelect = $('#FirstPaymentSelect');
            const $monthlyPaymentInput = $('#MonthlyPayment');
            const $monthlyPaymentLi = $('#MonthlyPaymentLi');
            const $totalPriceInput = $('#TotalPrice');

            // إظهار/إخفاء خيارات التقسيط مع alert
            function toggleInstallmentFields() {
                const value = $installmentSelect.val();



                if (value === 'installment' || value === 'k-net') {
                    $installmentFields.show();
                    updateMonthlyPayment();
                } else {
                    $installmentFields.hide();
                    $monthlyPaymentLi.hide();
                    $monthlyPaymentInput.val(0);
                }
            }

            // حساب الدفعة الشهرية
            function updateMonthlyPayment() {
                const selectedMonths = parseInt($installmentBySelect.val()) || 0;
                let firstPaymentValue = 0;

                if ($firstPaymentSelect.length) {
                    firstPaymentValue = parseFloat($firstPaymentSelect.val()) || 0;
                } else if ($firstPaymentInput.length) {
                    firstPaymentValue = parseFloat($firstPaymentInput.val()) || 0;
                }

                const totalPriceValue = parseFloat($totalPriceInput.val()) || 0;

                if (selectedMonths > 0) {
                    const remainingAmount = totalPriceValue - firstPaymentValue;
                    if (remainingAmount >= 0) {
                        const monthlyPayment = (remainingAmount / selectedMonths).toFixed(2);
                        $monthlyPaymentLi.show();
                        $monthlyPaymentInput.val(monthlyPayment);
                    } else {
                        alert("الدفعة الأولى أكبر من المجموع الكلي!");
                        if ($firstPaymentSelect.length) $firstPaymentSelect.val('');
                        if ($firstPaymentInput.length) $firstPaymentInput.val(0);
                        $monthlyPaymentLi.hide();
                        $monthlyPaymentInput.val(0);
                    }
                }
            }

            // تفعيل الحدث عند اختيار طريقة الدفع
            $installmentSelect.on('change', toggleInstallmentFields);

            // تفعيل حساب الدفعة الشهرية عند تغيير عدد الأشهر
            $installmentBySelect.on('change', updateMonthlyPayment);

            // التغييرات على الدفعة الأولى
            if ($firstPaymentInput.length) $firstPaymentInput.on('input', updateMonthlyPayment);
            if ($firstPaymentSelect.length) $firstPaymentSelect.on('change', function() {
                $firstPaymentInput.val($(this).val());
                updateMonthlyPayment();
            });

            // تنفيذ عند تحميل الصفحة
            toggleInstallmentFields();
        });
    </script>
    <script>
        $(document).ready(function() {
            $("form[action='{{ route('send_data_new') }}']").on("submit", function(e) {
                e.preventDefault(); // منع الريلود العادي

                let form = $(this);
                let formData = form.serialize();

                // إظهار اللودر
                $("#loader").show();

                $.ajax({
                    url: form.attr("action"),
                    type: "POST",
                    data: formData,
                    success: function(response) {
                       $("#loader").hide(); // إخفاء اللودر
                                $("#payContent").html(
                                response); // عرض المحتوى أسفل الفورم
                                $('html, body').animate({
                                    scrollTop: $("#payContent").offset().top
                                }, 500);
                    },
                    error: function(xhr) {
                        $("#loader").hide();
                        alert("فشل إرسال الطلب. تحقق من البيانات.");
                    }
                });
            });
        });
    </script>

@endsection
