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
        <nav aria-label="breadcrumb " style="margin: 20px">
            <ol class="breadcrumb mt-4">
                <li class="breadcrumb-item text-info"><a href="/" class="text-info text-decoration-none"
                        style="font-size: 14px;">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="font-size: 14px;">سلة المشتريات</li>
            </ol>
        </nav>
        <div class="row my-2">
            <!-- itmes -->
            <div class="col-md-12 my-2">

                <div class="container rounded  bg-white p-5 text-center " style="color: #121f41;">
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
            <div class="col-md-4 text-secondary d-none">
                <div class="container rounded bg-white shadow border my-2 px-3 py-2">
                    <h5 class="border-bottom py-3 mb-3 fw-normal">تفاصيل الفاتورة</h5>
                    <div class="row my-2">
                        <div class="col-6">قيمة المنتجات :</div>
                        <div class="col-6 text-end">0 </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-6">التوصيل:</div>
                        <div class="col-6 text-end">00.00 </div>
                    </div>
                    <div class="row my-2 border-top pt-2 text-dark fw-semibold">
                        <div class="col-6">المجموع الكلي :</div>
                        <div class="col-6 text-end text-success">0 </div>
                    </div>
                    <div class="row mt-5 mb-3">
                        <div class="col-12">
                            <a href="index-2.html" class="btn w-100 btn-outline-dark">
                                <i class="fas fa-angle-right fa-fw"></i>
                                متابعة التسوق
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <nav aria-label="breadcrumb " style="margin: 20px">
            <ol class="breadcrumb mt-4">
                <li class="breadcrumb-item text-info"><a href="/" class="text-info text-decoration-none"
                        style="font-size: 14px;">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page" style="font-size: 14px;">سلة المشتريات</li>
            </ol>
        </nav>
        <section class="container mt-3">



            <div class="">

                <div class="row my-2">
                    <div class="col-md-12 my-2">
                        @foreach ($cart as $item)
                            <div class="container rounded border bg-white mb-3 product-item"
                                data-price="{{ $item['price'] }}" data-quantity="{{ $item['quantity'] }}">
                                @php
                                    $product = \App\Models\Product::find($item['id']);
                                @endphp
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
                                            {{ get_general_value('currancy') }}</span>
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
                                                        <input type="number"
                                                            class="text-center form-control quantity-input"
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
                                                    {{ get_general_value('currancy') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- زر الحذف بجانب العناصر في الشاشات الصغيرة والكبيرة -->
                                    <div
                                        class="col-1 col-md-1 mt-md-0 my-2 d-flex align-items-center justify-content-center">
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


                    <!-- Add jQuery code for increase/decrease functionality -->



                    <div class="container mt-4 rounded bg-white border py-4">
                        <h5 class="fw-bold text-black mb-3">مجموع السلة</h5>

                        <div class="row">
                            <div class="col-6">الإجمالي:</div>
                            <div class="col-6 text-end fw-bold total_price">{{ $totalPrice }}
                                {{ get_general_value('currancy') }}</div>
                        </div>

                    </div>
                    <form action="{{ route('send_data') }}" method="POST"
                        class="row align-items-center justify-content-center justify-content-lg-start">
                        @csrf
                        <div class="product-options mt-4 rounded bg-white border py-4 px-4">
                            <h5 class="fw-bold text-black mb-3">تفاصيل الطلب</h5>

                            <!-- Full Name -->
                            <div class="form-group mb-3">
                                <label class="product-option-name required">الاسم كاملا</label>
                                <input type="text" id="fullName" name="name" class="form-control"
                                    placeholder="الاسم كاملا" required="">
                            </div>

                            <!-- Email -->
                            <div class="form-group mb-3">
                                <label class="product-option-name required">الايميل</label>
                                <input type="email" id="email" name="email" class="form-control"
                                    placeholder="الايميل" required="">
                            </div>

                            <!-- WhatsApp Number -->
                            <div class="form-group mb-3">
                                <label class="product-option-name required">رقم الواتس</label>
                                <input type="text" id="WhatsApp" name="whatsApp" class="form-control"
                                    placeholder="رقم الواتس" required="">
                            </div>

                            <!-- Full Address -->
                            <div class="form-group mb-3">
                                <label class="product-option-name required">العنوان كاملا</label>
                                <input type="text" id="address" name="address" class="form-control"
                                    placeholder="العنوان كاملا" required="">
                            </div>

                            <!-- Payment Method -->
                            <div class="form-group mb-3">
                                <label class="product-option-name required">طريقة الدفع</label>
                                <select class="form-control" id="installment" name="payment_method" required="">
                                    <option value="" selected="" disabled="">اختر</option>
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

                            <!-- Total Price -->
                            <div class="form-group mb-3 installment">
                                <label class="product-option-name required">المجموع الكلي</label>
                                <input value="{{ $totalPrice }}" id="TotalPrice" name="TotalPrice"
                                    class="form-control" type="number" readonly="">
                            </div>

                            <!-- First Payment -->
                            <div class="form-group mb-3 installment">
                                <label class="product-option-name required">الدفعة الاولى</label>
                                <input value="{{ get_general_value('batch') }}" min="0" readonly=""
                                    id="FirstPayment" name="FirstPayment" class="form-control" type="number">
                            </div>

                            <!-- Installment By -->
                            <div class="form-group mb-3 installment">
                                <label class="product-option-name required">الرجاء تحديد عدد شهور التقسيط </label>
                                <select name="InstallmentBy" id="InstallmentBy" class="form-control">
                                    <option value="1">1 شهر</option>
                                    <option value="2">2 شهر</option>
                                    <option value="3">3 شهر</option>
                                    <option value="4">4 شهر</option>
                                    <option value="5">5 شهر</option>
                                    <option value="6">6 شهر</option>
                                    <option value="7">7 شهر</option>
                                    <option value="8">8 شهر</option>
                                    <option value="9">9 شهر</option>
                                    <option value="10">10 شهر</option>
                                    <option value="11">11 شهر</option>
                                    <option value="12">12 شهر</option>
                                    <option value="13">13 شهر</option>
                                    <option value="14">14 شهر</option>
                                    <option value="15">15 شهر</option>
                                    <option value="16">16 شهر</option>
                                    <option value="17">17 شهر</option>
                                    <option value="18">18 شهر</option>
                                    <option value="19">19 شهر</option>
                                    <option value="20">20 شهر</option>
                                    <option value="21">21 شهر</option>
                                    <option value="22">22 شهر</option>
                                    <option value="23">23 شهر</option>
                                    <option value="24">24 شهر</option>
                                </select>
                            </div>

                            <!-- Monthly Payment -->
                            <div class="form-group mb-3 installment" id="MonthlyPaymentLi" style="display:none;">
                                <label class="product-option-name required">الدفعة الشهرية</label>
                                <input value="0" readonly="" id="MonthlyPayment" name="MonthlyPayment"
                                    class="form-control">
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group text-end">
                                <button type="submit" class="btn btn-primary w-100">إتمام الطلب</button>
                            </div>
                        </div>
                    </form>


                </div>

            </div>
        </section>
        <div class="floating-box">
            <h5>السعر الإجمالي</h5>
            <p id="floatingTotal">{{ $totalPrice }} {{ get_general_value('currancy') }}</p>

        </div>

        <a href="https://wa.me/{{ get_general_value('whatsapp') }}" class="contact p-1 rounded-circle text-center"
            style="background-color:#4dc247;width:50px;height:50px;">
            <i class="fab fa-whatsapp text-white my-1 fa-2x"></i>
        </a>
        </main>
    @endif
@endsection
@section('scripts')
<script>
$(document).ready(function() {
    // Elements
    const installmentSelect = $('#installment');
    const installmentElements = $('.installment');
    const installmentBySelect = $('#InstallmentBy');
    const firstPaymentInput = $('#FirstPayment');
    const firstPaymentSelect = $('#FirstPaymentSelect');
    const monthlyPaymentInput = $('#MonthlyPayment');
    const monthlyPaymentLi = $('#MonthlyPaymentLi');
    const totalPriceInput = $('#TotalPrice');

    // Function to show/hide installment fields
    function toggleInstallmentFields() {
        const value = installmentSelect.val();

        // Alert عند الاختيار
        if (value) {
            alert("لقد اخترت طريقة الدفع: " + value);
        }

        if (value === 'installment' || value === 'k-net') {
            installmentElements.show();
            updateMonthlyPayment();
        } else {
            installmentElements.hide();
            monthlyPaymentLi.hide();
            monthlyPaymentInput.val(0);
        }
    }

    // Function to calculate monthly payment
    function updateMonthlyPayment() {
        const selectedMonths = parseInt(installmentBySelect.val()) || 0;
        let firstPaymentValue = 0;

        if (firstPaymentSelect.length) {
            firstPaymentValue = parseFloat(firstPaymentSelect.val()) || 0;
        } else if (firstPaymentInput.length) {
            firstPaymentValue = parseFloat(firstPaymentInput.val()) || 0;
        }

        const totalPriceValue = parseFloat(totalPriceInput.val()) || 0;

        if (selectedMonths > 0) {
            const remainingAmount = totalPriceValue - firstPaymentValue;

            if (remainingAmount >= 0) {
                const monthlyPayment = (remainingAmount / selectedMonths).toFixed(2);
                monthlyPaymentLi.show();
                monthlyPaymentInput.val(monthlyPayment);
            } else {
                alert("الدفعة الأولى أكبر من المجموع الكلي!");
                if (firstPaymentSelect.length) firstPaymentSelect.val("");
                if (firstPaymentInput.length) firstPaymentInput.val(0);
                monthlyPaymentLi.hide();
                monthlyPaymentInput.val(0);
            }
        }
    }

    // Event listeners
    installmentSelect.change(toggleInstallmentFields);
    installmentBySelect.change(updateMonthlyPayment);

    if (firstPaymentInput.length) firstPaymentInput.on('input', updateMonthlyPayment);
    if (firstPaymentSelect.length) firstPaymentSelect.change(function() {
        firstPaymentInput.val($(this).val());
        updateMonthlyPayment();
    });

    // Trigger on page load
    toggleInstallmentFields();

    // Quantity update logic (existing)
    $('.increase-btn, .decrease-btn').click(function() {
        var form = $(this).closest('form');
        var quantityInput = form.find('.quantity-input');
        var quantity = parseInt(quantityInput.val()) || 0;

        if ($(this).hasClass('increase-btn')) quantityInput.val(quantity + 1);
        else if ($(this).hasClass('decrease-btn') && quantity > 1) quantityInput.val(quantity - 1);

        updateCartQuantity(form);
    });

    $('.quantity-input').change(function() {
        var form = $(this).closest('form');
        updateCartQuantity(form);
    });

    function updateCartQuantity(form) {
        var itemKey = form.find('input[name="itemKey"]').val();
        var quantity = form.find('.quantity-input').val();

        $.ajax({
            url: '{{ route('cart.update') }}',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                itemKey: itemKey,
                quantity: quantity,
            },
            success: function(response) {
                if (response.status === 'success') {
                    var currany = "{{ get_general_value('currancy') }}";
                    $('.total-price[data-item-key="' + itemKey + '"]').text(
                        'المجموع: ' + (response.cart[itemKey].price * response.cart[itemKey].quantity) + ' ' + currany
                    );
                    $('#floatingTotal').text(response.totalPrice + ' ' + currany);
                    $('.total_price').text(response.totalPrice + ' ' + currany);
                    $('#TotalPrice').val(response.totalPrice);
                    toggleInstallmentFields();
                }
            }
        });
    }
});
</script>
@endsection
