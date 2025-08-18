<x-filament-panels::page>
    <div class="overflow-x-auto">
        <table class="w-full text-right rtl:text-right whitespace-nowrap border border-gray-200 dark:border-gray-700 rounded-lg">
            <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                <tr>
                    <th class="px-4 py-2 border-b">#</th>
                    <th class="px-4 py-2 border-b">اسم الصفحة</th>
                    <th class="px-4 py-2 border-b">الدخول للرابط</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                <tr>
                    <td class="px-4 py-2 border-b">1</td>
                    <td class="px-4 py-2 border-b">صفحة الاعدادات</td>
                    <td class="px-4 py-2 border-b text-blue-600">
                        <a href="{{route('filament.admin.pages.data-setting') }}" target="_blank">مشاهدة الصفحة</a>
                    </td>
                </tr>
                  <tr>
                    <td class="px-4 py-2 border-b">1</td>
                    <td class="px-4 py-2 border-b">اعدادات الدفع </td>
                    <td class="px-4 py-2 border-b text-blue-600">
                        <a href="{{route('filament.admin.resources.payment-settings.index') }}" target="_blank">مشاهدة الصفحة</a>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2 border-b">2</td>
                    <td class="px-4 py-2 border-b">من نحن و الاسترجاع و الاسترداد</td>
                    <td class="px-4 py-2 border-b text-blue-600">
                        <a href="{{ route('filament.admin.pages.data-pages') }}" target="_blank">مشاهدة الصفحة</a>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2 border-b">3</td>
                    <td class="px-4 py-2 border-b">القوائم بالصفحة الرئيسية</td>
                    <td class="px-4 py-2 border-b text-blue-600">
                        <a href="{{ route('filament.admin.resources.main-cats.index') }}" target="_blank">مشاهدة الصفحة</a>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2 border-b">4</td>
                    <td class="px-4 py-2  border-b">صور السلايدر </td>

                    <td class="px-4 py-2   border-b text-blue-600">
                        <a href="{{route('filament.admin.resources.sliders.index') }}" target="_blank">مشاهدة الصفحة</a>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2">5</td>
                    <td class="px-4 py-2 border-b">الصور في الفوتر</td>

                    <td class="px-4 py-2   border-b text-blue-600">
                        <a href="{{route('filament.admin.resources.paymentimages.index')}}" target="_blank">مشاهدة الصفحة</a>
                    </td>
                </tr>
                  <tr>
                    <td class="px-4 py-2">5</td>
                    <td class="px-4 py-2 border-b"> رفع ملفات </td>

                    <td class="px-4 py-2   border-b text-blue-600">
                        <a href="{{ url('/admin/data-uploader') }}" target="_blank">مشاهدة الصفحة</a>
                    </td>
                </tr>
                <tr>
                    <td class="px-4 py-2">5</td>
                    <td class="px-4 py-2 border-b"> (ممكن يتسغرق بعض الوقت)  تجديد الصور الكاتجوري  </td>

                    <td class="px-4 py-2   border-b text-blue-600">
                        <a href="{{ url('/csrab') }}" target="_blank">مشاهدة الصفحة</a>
                    </td>
                </tr>
            </tbody>
            

        </table>

        <p class="text-sm text-gray-500 mt-4 text-center">Showing 1 to 5 of 5 entries</p>
    </div>
</x-filament-panels::page>
