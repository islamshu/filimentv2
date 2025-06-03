<x-filament-panels::page>
    <style>
        /* Toggle Switch بنفس أسلوب الصفحة */
        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #00baf2;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }

        /* تصميم متجاوب للأجهزة المحمولة */
        @media (max-width: 570px) {
            .switch {
                width: 45px;
                height: 22px;
            }

            .slider:before {
                height: 14px;
                width: 14px;
            }
        }
    </style>
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
            <!-- Card Header -->
            <div class="bg-primary-600 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-bold text-white">تحديث إعدادات الموقع</h2>
            </div>

            <!-- Card Body -->
            <div class="p-6">
                <form action="{{ route('filament.admin.settings.generral.add') }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Website Basic Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label for="website_name" class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            اسم الموقع (عربي)
                        </label>
                        <div class="md:col-span-2">
                            <input type="text" id="website_name" name="general[website_name]"
                                value="{{ get_general_value('website_name') ?? old('general.website_name') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                placeholder="أدخل اسم الموقع بالعربية">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label for="website_name_en" class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            اسم الموقع (إنجليزي)
                        </label>
                        <div class="md:col-span-2">
                            <input type="text" id="website_name_en" name="general[website_name_en]"
                                value="{{ get_general_value('website_name_en') ?? old('general.website_name_en') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                placeholder="أدخل اسم الموقع بالإنجليزية">
                        </div>
                    </div>

                    <!-- Website Logo -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label for="web_logo" class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            شعار الموقع
                        </label>
                        <div class="md:col-span-2">
                            <div class="flex flex-col gap-4">
                                <div class="flex items-center gap-4">
                                    @if ($currentLogo = get_general_value('web_logo'))
                                        <div class="flex-shrink-0">
                                            <img id="currentLogo" src="{{ asset('storage/' . $currentLogo) }}"
                                                alt="شعار الموقع الحالي" class="h-16 w-16 rounded-md object-cover">
                                        </div>
                                    @endif

                                    <label class="block">
                                        <span class="sr-only">اختر ملف</span>
                                        <input type="file" id="web_logo" name="general_file[web_logo]"
                                            class="block w-full text-sm text-gray-500 dark:text-gray-400
                                                      file:mr-4 file:py-2 file:px-4
                                                      file:rounded-md file:border-0
                                                      file:text-sm file:font-semibold
                                                      file:bg-primary-50 file:text-primary-700 dark:file:bg-gray-700 dark:file:text-primary-300
                                                      hover:file:bg-primary-100 dark:hover:file:bg-gray-600">
                                    </label>
                                </div>

                                <!-- مكان ظهور معاينة الصورة -->
                                <div id="previewContainer" class="hidden mt-2">
                                    <img id="previewImage" src="" class="h-16 w-16 rounded-md object-cover"
                                        alt="معاينة الشعار الجديد">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label for="segnature" class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            شعار الموقع
                        </label>
                        <div class="md:col-span-2">
                            <div class="flex flex-col gap-4">
                                <div class="flex items-center gap-4">
                                    @if ($segnatureLogo = get_general_value('segnature'))
                                        <div class="flex-shrink-0">
                                            <img id="segnatureLogo" src="{{ asset('storage/' . $segnatureLogo) }}"
                                                alt="شعار الموقع الحالي" class="h-16 w-16 rounded-md object-cover">
                                        </div>
                                    @endif

                                    <label class="block">
                                        <span class="sr-only">اختر ملف</span>
                                        <input type="file" id="segnature" name="general_file[segnature]"
                                            class="block w-full text-sm text-gray-500 dark:text-gray-400
                                                      file:mr-4 file:py-2 file:px-4
                                                      file:rounded-md file:border-0
                                                      file:text-sm file:font-semibold
                                                      file:bg-primary-50 file:text-primary-700 dark:file:bg-gray-700 dark:file:text-primary-300
                                                      hover:file:bg-primary-100 dark:hover:file:bg-gray-600">
                                    </label>
                                </div>

                                <!-- مكان ظهور معاينة الصورة -->
                                <div id="previewContainer" class="hidden mt-2">
                                    <img id="previewImage" src="" class="h-16 w-16 rounded-md object-cover"
                                        alt="معاينة الشعار الجديد">
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- سكربت المعاينة -->


                    <!-- Colors -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label for="primary_color" class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            اللون الأساسي
                        </label>
                        <div class="md:col-span-2">
                            <input type="color" id="primary_color" name="general[primary_color]"
                                value="{{ get_general_value('primary_color') ?? old('general.primary_color') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500 h-10">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label for="forgin_color" class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            اللون الثانوي
                        </label>
                        <div class="md:col-span-2">
                            <input type="color" id="forgin_color" name="general[forgin_color]"
                                value="{{ get_general_value('forgin_color') ?? old('general.forgin_color') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500 h-10">
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label for="email" class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            البريد الإلكتروني
                        </label>
                        <div class="md:col-span-2">
                            <input type="email" id="email" name="general[email]"
                                value="{{ get_general_value('email') ?? old('general.email') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                placeholder="example@domain.com">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label for="phone" class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            رقم الهاتف
                        </label>
                        <div class="md:col-span-2">
                            <input type="text" id="phone" name="general[phone]"
                                value="{{ get_general_value('phone') ?? old('general.phone') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                placeholder="أدخل رقم الهاتف">
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label for="facebook" class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            فيسبوك
                        </label>
                        <div class="md:col-span-2">
                            <input type="text" id="facebook" name="general[facebook]"
                                value="{{ get_general_value('facebook') ?? old('general.facebook') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                placeholder="رابط صفحة الفيسبوك">
                        </div>
                    </div>

                    <!-- باقي روابط السوشيال ميديا بنفس الطريقة -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label for="twitter" class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            تويتر
                        </label>
                        <div class="md:col-span-2">
                            <input type="text" id="twitter" name="general[twitter]"
                                value="{{ get_general_value('twitter') ?? old('general.twitter') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                placeholder="رابط حساب تويتر">
                        </div>
                    </div>

                    <!-- WhatsApp -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label for="whatsapp" class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            واتساب
                        </label>
                        <div class="md:col-span-2">
                            <input type="text" id="whatsapp" name="general[whatsapp]"
                                value="{{ get_general_value('whatsapp') ?? old('general.whatsapp') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                placeholder="رابط رقم الواتساب">
                        </div>
                    </div>

                    <!-- Instagram -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label for="instagram" class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            انستغرام
                        </label>
                        <div class="md:col-span-2">
                            <input type="text" id="instagram" name="general[instagram]"
                                value="{{ get_general_value('instagram') ?? old('general.instagram') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                placeholder="رابط حساب انستغرام">
                        </div>
                    </div>

                    <!-- YouTube -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label for="youtube" class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            يوتيوب
                        </label>
                        <div class="md:col-span-2">
                            <input type="text" id="youtube" name="general[youtube]"
                                value="{{ get_general_value('youtube') ?? old('general.youtube') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                placeholder="رابط قناة اليوتيوب">
                        </div>
                    </div>

                    <!-- Snapchat -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label for="snapchat" class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            سناب شات
                        </label>
                        <div class="md:col-span-2">
                            <input type="text" id="snapchat" name="general[snapchat]"
                                value="{{ get_general_value('snapchat') ?? old('general.snapchat') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                placeholder="رابط حساب سناب شات">
                        </div>
                    </div>

                    <!-- TikTok -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label for="tiktok" class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            تيك توك
                        </label>
                        <div class="md:col-span-2">
                            <input type="text" id="tiktok" name="general[tiktok]"
                                value="{{ get_general_value('tiktok') ?? old('general.tiktok') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                placeholder="رابط حساب تيك توك">
                        </div>
                    </div>

                    <!-- العملة -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label for="currancy" class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            العملة
                        </label>
                        <div class="md:col-span-2">
                            <select name="general[currancy]"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                id="">
                                <option value="" selected disabled>اختر</option>
                                <option value="ر.س" @if (get_general_value('currancy') == 'ر.س') selected @endif>ريال سعودي
                                </option>
                                <option value="$" @if (get_general_value('currancy') == '$') selected @endif>دولار امريكي
                                </option>
                                <option value="د.إ" @if (get_general_value('currancy') == 'د.إ') selected @endif>درهم إماراتي
                                </option>
                                <option value="ر.ع"@if (get_general_value('currancy') == 'ر.ع') selected @endif>ريال عماني
                                </option>
                                <option value="د.ك"@if (get_general_value('currancy') == 'د.ك') selected @endif>دينار كويتي
                                </option>
                                <option value="ر.ق"@if (get_general_value('currancy') == 'ر.ق') selected @endif>ريال قطري
                                </option>
                                <option value="د.ب"@if (get_general_value('currancy') == 'د.ب') selected @endif>دينار بحريني
                                </option>
                            </select>

                        </div>
                    </div>

                    <!-- التوقيع -->


                    <!-- الدفعة -->
                    {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label for="batch" class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            ٌقيمة الدفعة الاولى

                        </label>
                        <div class="md:col-span-2">
                            <input type="text" id="batch" name="general[batch]"
                                value="{{ get_general_value('batch') ?? old('general.batch') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                placeholder="أدخل الدفعة الاولى">
                        </div>
                    </div> --}}
                    <!-- خيارات الدفع -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            خيارات نظام الدفع
                        </label>
                        <div class="md:col-span-2 space-y-6">
                            <!-- خيار الدفعة المخصصة -->
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        تفعيل الدفعة المخصصة
                                    </label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        تحديد قيمة واحدة للدفعة الأولى
                                    </p>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" name="general[custom_payment_enabled]" value="1"
                                        @if (get_general_value('custom_payment_enabled')) checked @endif id="customPaymentToggle">
                                    <span class="slider round"></span>
                                </label>
                            </div>

                            <!-- حقل الدفعة المخصصة (يظهر عند التفعيل) -->
                            <div id="customPaymentField"
                                class="@if (!get_general_value('custom_payment_enabled')) hidden @endif pl-4 pr-2">
                                <label for="batch"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    قيمة الدفعة المخصصة
                                </label>
                                <input type="text" id="batch" name="general[batch]"
                                    value="{{ get_general_value('batch') ?? old('general.batch') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                    placeholder="أدخل قيمة الدفعة الأولى">
                            </div>

                            <!-- خيار الدفعات المتعددة -->
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div>
                                    <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        تفعيل الدفعات المتعددة
                                    </label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        إمكانية تحديد عدة قيم للدفعات
                                    </p>
                                </div>
                                <label class="switch">
                                    <input type="checkbox" name="general[multiple_payments_enabled]" value="1"
                                        @if (get_general_value('multiple_payments_enabled')) checked @endif id="multiplePaymentsToggle">
                                    <span class="slider round"></span>
                                </label>
                            </div>

                            <!-- حقول الدفعات المتعددة (تظهر عند التفعيل) -->
                            <div id="multiplePaymentsFields"
                                class="@if (!get_general_value('multiple_payments_enabled')) hidden @endif space-y-3 pl-4 pr-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    قيم الدفعات المتعددة
                                </label>

                                <div id="paymentsContainer">
                                    @php
                                        $multiple_payments =
                                            json_decode(get_general_value('multiple_payments') ?? '[]', true) ?? [];
                                    @endphp

                                    @if (count($multiple_payments) > 0)
                                        @foreach ($multiple_payments as $index => $payment)
                                            <div class="flex gap-2 payment-input mb-2">
                                                <input type="text" name="multiple_payments[]"
                                                    value="{{ $payment }}"
                                                    class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                                    placeholder="قيمة الدفعة">
                                                @if ($index > 0)
                                                    <button type="button"
                                                        class="remove-payment-btn px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition">حذف</button>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="flex gap-2 payment-input mb-2">
                                            <input type="text" name="multiple_payments[]"
                                                class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                                placeholder="قيمة الدفعة">
                                        </div>
                                    @endif
                                </div>

                                <button type="button" id="addPaymentBtn"
                                    class="px-4 py-2 bg-primary-600 text-white rounded-md text-sm hover:bg-primary-700 transition">
                                    + إضافة دفعة أخرى
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- الرقم الضريبي -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label for="number_dareba" class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            الرقم الضريبي
                        </label>
                        <div class="md:col-span-2">
                            <input type="text" id="number_dareba" name="general[number_dareba]"
                                value="{{ get_general_value('number_dareba') ?? old('general.number_dareba') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                placeholder="أدخل الرقم الضريبي">
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between p-3 rounded">

                        <input type="hidden" name="general[kent_payment]" value="off">

                        <!-- Visible checkbox -->
                        <label for="daman_text" class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            تقسيط كي نت
                        </label>
                        <label class="switch md:col-span-2">
                            <input type="checkbox" name="general[kent_payment]" value="on"
                                @if (get_general_value('kent_payment') == 'on') checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="d-flex align-items-center justify-content-between p-3 rounded">

                        <input type="hidden" name="general[tappy_tamara_payment]" value="off">

                        <!-- Visible checkbox -->
                        <label for="daman_text" class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            تقسيط تابي و تمارة
                        </label>
                        <label class="switch md:col-span-2">
                            <input type="checkbox" name="general[tappy_tamara_payment]" value="on"
                                @if (get_general_value('tappy_tamara_payment') == 'on') checked @endif>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label for="daman_text" class="text-sm font-medium text-gray-900 dark:text-gray-300 pt-2">
                            نص الضمان
                        </label>
                        <div class="md:col-span-2">
                            <input type="text" id="daman_text" name="general[daman_text]"
                                value="{{ get_general_value('daman_text') ?? old('general.daman_text') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                placeholder="أدخل نص الضمان ">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-4">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-full shadow-sm text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('web_logo').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('previewContainer');
            const previewImage = document.getElementById('previewImage');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('hidden');
                previewImage.src = '';
            }
        });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const customPaymentToggle = document.getElementById('customPaymentToggle');
        const multiplePaymentsToggle = document.getElementById('multiplePaymentsToggle');
        const customPaymentField = document.getElementById('customPaymentField');
        const multiplePaymentsFields = document.getElementById('multiplePaymentsFields');
        const paymentsContainer = document.getElementById('paymentsContainer');
        const addPaymentBtn = document.getElementById('addPaymentBtn');

        function toggleCustomPayment(enabled) {
            customPaymentToggle.checked = enabled;
            customPaymentField.classList.toggle('hidden', !enabled);
            if (enabled) {
                // Disable multiple payments
                multiplePaymentsToggle.checked = false;
                multiplePaymentsFields.classList.add('hidden');
            }
        }

        function toggleMultiplePayments(enabled) {
            multiplePaymentsToggle.checked = enabled;
            multiplePaymentsFields.classList.toggle('hidden', !enabled);
            if (enabled) {
                // Disable custom payment
                customPaymentToggle.checked = false;
                customPaymentField.classList.add('hidden');
            }
        }

        // أحداث التبديل بين الخيارين
        customPaymentToggle.addEventListener('change', function () {
            toggleCustomPayment(this.checked);
        });

        multiplePaymentsToggle.addEventListener('change', function () {
            toggleMultiplePayments(this.checked);
        });

        // إضافة دفعة جديدة
        if (addPaymentBtn) {
            addPaymentBtn.addEventListener('click', function () {
                const newInputDiv = document.createElement('div');
                newInputDiv.className = 'flex gap-2 payment-input mb-2';
                newInputDiv.innerHTML = `
                    <input type="text" name="multiple_payments[]" 
                           class="flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                           placeholder="قيمة الدفعة" required>
                    <button type="button" class="remove-payment-btn px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 transition">حذف</button>
                `;
                paymentsContainer.appendChild(newInputDiv);
            });
        }

        // حذف دفعة
        if (paymentsContainer) {
            paymentsContainer.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-payment-btn')) {
                    e.target.closest('.payment-input').remove();
                }
            });
        }
    });
</script>

</x-filament-panels::page>
