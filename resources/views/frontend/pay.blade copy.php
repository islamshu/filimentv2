@extends('layouts.frontend')
@section('title', 'الدفع')
@section('content')
    <div class="loaderk d-flex justify-content-center align-items-center" style="display: none; height: 0px;"></div>

    <main>
        <section class="mt-5 py-3"></section>

        <div class="container col-md-7" style="border-radius:5px;">
            <div class="mt-3 pb-3 border-bottom pay-header">
                <div class="hide">
                    <div class="d-flex" style="padding: 15px;">
                        <div class="store-info__logo me-3">
                            <img src="{{ asset(get_general_value('web_logo')) }}" class=""
                                style="display: inline-block;" width="60" alt="">
                        </div>
                        <div class="">
                            <h6>مرحباً بك</h6>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb pt-md-0 pt-2">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}"
                                            class="text-decoration text-black-50">الرئيسية</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('cart.index') }}"
                                            class="text-decoration text-black-50">سلة المشتريات</a></li>
                                    <li class="breadcrumb-item active text-black" aria-current="page">انهاء الطلب</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <div class="d-none" id="bill-box" style="padding: 15px;">
                        <div class="d-flex justify-content-between mt-4">
                            <span>ملخص السلة</span>
                            <span>{{ $totalPrice }} <span>{{ get_general_value('currancy') }}</span></span>
                        </div>
                    </div>

                    <div class="line"></div>

                    <div class="d-flex justify-content-between mt-4" style="padding: 15px;">
                        <span>اجمالي الطلب</span>
                        <div class="">
                            <span class="d-block text-end">{{ $totalPrice }}
                                <span>{{ get_general_value('currancy') }}</span>
                                <a href="" class="text-danger d-block" style="font-size: 12px;">لديك كوبون تخفيض
                                    ؟</a>
                        </div>
                    </div>
                </div>

                <div class="btn-box">
                    <a href="" id="bill-btn" class="text-black btn m-auto pill-btn">
                        <i class="fa-solid fa-chevron-down d-none" id='down'></i>
                        <i class="fa-solid fa-chevron-up" id="up"></i> تفاصيل الفاتورة
                    </a>
                </div>
            </div>

            <div class="sections-wrapper">
                <div class="container mb-5">
                    <form action="{{ route('send_pay') }}" method="POST" class="pb-2" id="paymentForm">
                        @csrf
                        <input type="hidden" name="totalPrice" value="{{ $totalPrice }}">
                    
                        <div class="row">
                            <!-- Payment Method Section -->
                            <div class="d-flex justify-content-start mb-3 mt-3">
                                <div class="d-flex">
                                    <span class="me-2"
                                        style="width:43px;height:43px;border-radius:50%;background-color:#00a8ff;color:white;display:flex;justify-content:center;align-items:center">
                                        <i class="fa-solid fa-money-bill"></i>
                                    </span>
                                    <div class="">
                                        <h6 style="margin-bottom: 0;">طريقة الدفع</h6>
                                        <span class="pay-name">فيزا</span>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="mb-3 pay-ways">
                                @if (in_array($payment_method, ['installment', 'all']))
                                    <div class="row px-3 justify-content-center justify-content-lg-start">
                                        <div class="form-check col-6 col-lg-2 col-md-3 border rounded py-1 m-1 p-1 d-flex align-items-center justify-content-center">
                                            <input class="form-check-input me-2" required type="radio" value="visa"
                                                name="paymentWay" id="visa">
                                            <label class="form-check-label text-center" for="visa">
                                                <img src="{{ asset('front/assets/image/icons/visa.png') }}" width="65"
                                                    height="35" class="mx-1" alt="">
                                            </label>
                                        </div>
                    
                                        <div class="form-check col-6 col-lg-2 col-md-3 border rounded py-1 m-1 p-1 d-flex align-items-center justify-content-center">
                                            <input class="form-check-input me-2" required type="radio" value="mastercard"
                                                name="paymentWay" id="mastercard">
                                            <label class="form-check-label text-center" for="mastercard">
                                                <img src="{{ asset('front/assets/image/icons/mastercard.png') }}"
                                                    width="65" height="35" class="mx-1" alt="">
                                            </label>
                                        </div>
                                @endif
                    
                                <input type="hidden" name="paymentt" id="paymentt">
                            </div>
                    
                            <!-- Payment Details Section -->
                            <div id="pay">
                                <p style="font-size: 14px;">
                                    في حالة اردت الشراء بالاقساط والاصناف المختارة تدعم الاقساط يرجى تحديد على كم قسط تريد
                                    التقسيط قبل تغيير الدفعة الاولى
                                </p>
                    
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="hidden" value="{{ $totalPrice }}" id="totalPrice">
                                        <span class="mb-1 d-inline-block spanlable">الدفع/التقسيط على</span>
                                        <select name="CashOrBatch" id="CashOrBatch" class="form-control rounded mb-3" required>
                                            <option value="0">نقدا</option>
                                            @if ($payment_method == 'installment')
                                                @for ($i = 1; $i <= 24; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ $i == $installment_by ? 'selected' : '' }}>{{ $i }}
                                                        شهر</option>
                                                @endfor
                                            @endif
                                        </select>
                                    </div>
                    
                                    @if ($payment_method == 'installment')
                                        <div class="col-lg-12">
                                            <span class="mb-1 d-inline-block spanlable">الدفعة الاولى</span>
                                            <input type="hidden" name="cart_count" id="cart_count"
                                                value="{{ $productCount }}">
                    
                                            <input type="text" name="first_batch" id="first_batch" readonly
                                                class="form-control rounded mb-3" value="{{ $first_payment }}"
                                                autocomplete="off" required placeholder="الدفعة الأولى">
                                        </div>
                    
                                        <div class="col-lg-12">
                                            <span class="mb-1 d-inline-block spanlable">قيمة كل قسط</span>
                                            <input type="text" id="all_batch" readonly
                                                class="form-control rounded mb-3"
                                                value="{{ number_format($monthly_payment, 2) }}" autocomplete="off"
                                                placeholder="قيمة كل قسط">
                                        </div>
                                    @endif
                    
                                    <!-- Card Details -->
                                    <div class="col-lg-6">
                                        <span class="mb-1 d-inline-block spanlable">الاسم على البطاقة</span>
                                        <input type="text" required class="form-control mb-3" name="card_name" id="name"
                                            autocomplete="off" placeholder="الأسم على البطاقة" pattern="[A-Za-z\u0600-\u06FF\s]+" title="يجب إدخال اسم صحيح">
                                    </div>
                    
                                    <div class="col-lg-6">
                                        <span class="mb-1 d-inline-block spanlable">رقم البطاقة</span>
                                        <input type="text" name="card_number" class="form-control" maxlength="16" 
                                        pattern="\d{16}" title="يجب أن يكون الرقم 16 رقمًا" required
                                        inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    </div>
                    
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <div class="container">
                                            <span class="mb-1 d-inline-block spanlable">تاريخ الانتهاء</span>
                                            <div class="row border rounded" style="overflow: hidden;">
                                                <div class="col-6 px-0 mx-0">
                                                    <input required type="text" class="form-control border-0" maxlength="2"
                                                        name="month" id="month" placeholder="الشهر" inputmode="numeric"
                                                        pattern="(0[1-9]|1[0-2])" title="يجب أن يكون الشهر بين 01 و 12"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                </div>
                                                <div class="col-6 px-0 mx-0">
                                                    <input required type="text"
                                                        class="form-control border border-right-0 border-top-0 border-left border-bottom-0 rounded-0"
                                                        maxlength="2" name="year" id="year" placeholder="السنة"
                                                        inputmode="numeric" pattern="\d{2}" title="أخر رقمين من السنة"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                    
                                    <div class="col-lg-3 col-md-6 col-sm-6">
                                        <span class="mb-1 d-inline-block spanlable">رمز التحقق (cvc)</span>
                                        <input required type="text" class="form-control" maxlength="3" name="cvc"
                                            id="cvc" placeholder="رمز التحقق (cvc)" inputmode="numeric"
                                            pattern="\d{3}" title="يجب أن يتكون من 3 أرقام"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                    </div>
                                </div>
                            </div>
                    
                            <!-- Submit Button -->
                            <div class="mt-4">
                                <button type="submit" name="confirm" id="CardBtn"
                                    style="background: {{ get_general_value('primary_color') }};color:white"
                                    class="btn w-100">
                                    <span>إكمال الدفع</span>
                                </button>
                            </div>
                    
                            <div class="container text-secondary mt-2 mb-4">
                                <p style="font-size: 14px;">
                                    تسوق إلكتروني آمن 100%
                                    <i class="fab fa-cc-amazon-pay fa-fw mx-1"></i>
                                    <i class="fab fa-cc-apple-pay fa-fw"></i>
                                    <i class="fas fa-shield fa-fw mx-1"></i>
                                </p>
                            </div>
                        </div>
                    </form>
                    
                
                    
                  
                </div>
            </div>
        </div>


    </main>
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('paymentForm');
        
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            // التحقق من الحقول المطلوبة
            const requiredFields = form.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = 'red';
                    // إظهار رسالة الخطأ إذا كان الحقل فارغًا
                    if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('error-message')) {
                        const errorMsg = document.createElement('div');
                        errorMsg.className = 'error-message text-danger mt-1';
                        errorMsg.textContent = 'هذا الحقل مطلوب';
                        field.parentNode.appendChild(errorMsg);
                    }
                } else {
                    field.style.borderColor = '';
                    // إزالة رسالة الخطأ إذا كانت موجودة
                    if (field.nextElementSibling && field.nextElementSibling.classList.contains('error-message')) {
                        field.nextElementSibling.remove();
                    }
                }
            });
    
            // تحقق من رقم البطاقة
            const cardNumber = form.querySelector('[name="card_number"]');
            if (cardNumber && !/^\d{16}$/.test(cardNumber.value)) {
                isValid = false;
                cardNumber.style.borderColor = 'red';
                if (!cardNumber.nextElementSibling || !cardNumber.nextElementSibling.classList.contains('error-message')) {
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'error-message text-danger mt-1';
                    errorMsg.textContent = 'يجب أن يتكون رقم البطاقة من 16 رقمًا';
                    cardNumber.parentNode.appendChild(errorMsg);
                }
            }
    
            // تحقق من تاريخ الانتهاء
            const month = form.querySelector('[name="month"]');
            const year = form.querySelector('[name="year"]');
            if (month && year) {
                const monthVal = parseInt(month.value);
                const yearVal = parseInt(year.value);
                
                if (monthVal < 1 || monthVal > 12) {
                    isValid = false;
                    month.style.borderColor = 'red';
                    if (!month.nextElementSibling || !month.nextElementSibling.classList.contains('error-message')) {
                        const errorMsg = document.createElement('div');
                        errorMsg.className = 'error-message text-danger mt-1';
                        errorMsg.textContent = 'يجب أن يكون الشهر بين 01 و 12';
                        month.parentNode.appendChild(errorMsg);
                    }
                }
                
                if (year.value.length !== 2) {
                    isValid = false;
                    year.style.borderColor = 'red';
                    if (!year.nextElementSibling || !year.nextElementSibling.classList.contains('error-message')) {
                        const errorMsg = document.createElement('div');
                        errorMsg.className = 'error-message text-danger mt-1';
                        errorMsg.textContent = 'يجب إدخال آخر رقمين من السنة';
                        year.parentNode.appendChild(errorMsg);
                    }
                }
            }
    
            // تحقق من CVC
            const cvc = form.querySelector('[name="cvc"]');
            if (cvc && !/^\d{3}$/.test(cvc.value)) {
                isValid = false;
                cvc.style.borderColor = 'red';
                if (!cvc.nextElementSibling || !cvc.nextElementSibling.classList.contains('error-message')) {
                    const errorMsg = document.createElement('div');
                    errorMsg.className = 'error-message text-danger mt-1';
                    errorMsg.textContent = 'يجب أن يتكون رمز التحقق من 3 أرقام';
                    cvc.parentNode.appendChild(errorMsg);
                }
            }
    
            if (!isValid) {
                e.preventDefault();
                alert('يرجى تعبئة جميع الحقول المطلوبة بشكل صحيح');
            }
        });
    
        // إضافة تحقق أثناء الكتابة
        const fields = form.querySelectorAll('input, select');
        fields.forEach(field => {
            field.addEventListener('input', function() {
                this.style.borderColor = '';
                if (this.nextElementSibling && this.nextElementSibling.classList.contains('error-message')) {
                    this.nextElementSibling.remove();
                }
            });
        });
    });
    </script>
@endsection
