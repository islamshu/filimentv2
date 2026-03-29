@extends('layouts.frontend')

@section('title', 'تم الطلب')

@section('content')
    <div class="container text-center" style="margin-top:120px; margin-bottom:80px;">

        <div style="background:#fff; padding:40px; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1);">

            <div style="font-size:60px; color:green;">✔️</div>

            <h2 class="mt-3">تم ارسال طلبك بنجاح</h2>

            <p class="mt-3" style="color:#555;">
                تم ارسال طلبك إلى مندوب التوصيل وسوف يتواصل معك خلال
                <strong>12 إلى 24 ساعة</strong>
            </p>

            <hr>

            <h5 class="mt-3">📋 تفاصيل الطلب</h5>

            <p>👤 اسم المستخدم : {{ $order->name }}</p>
            <p>📞 رقم الهاتف الاول : {{ $order->phone }}</p>
            <p>📞 رقم الهاتف الثاني : {{ $order->phone2 }}</p>
            <p>💬 رقم الواتسب : {{ $order->whatsapp }}</p>
            <p>📍العنوان : {{ $order->location }}</p>
            <p>💰 المجموع الكلي : {{ $order->payment }} {{ get_currancy() }}</p>

            @if ($order['note'])
                <p>📝 الملاحظات : {{ $order->note }}</p>
            @endif

            <a href="/" class="btn btn-primary mt-4 px-4">العودة للرئيسية</a>

        </div>
    </div>
@endsection
