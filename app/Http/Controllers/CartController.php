<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // تأكد أنك مستورد المنتج
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;

class CartController extends Controller
{
    public function index()
{
    $cart = session()->get('cart', []);

    // إنشاء كابتشا نصي بسيط (وليس عملية رياضية)
    $text = Str::upper(Str::random(5)); // مثل: H8G9K
    $token = Str::random(20);

    session([
        'captcha_text' => $text,
        'captcha_token' => $token,
        'captcha_used' => false,
    ]);

    // حساب المجموع الكلي
    $totalPrice = 0;
    foreach ($cart as $item) {
        $totalPrice += $item['price'] * $item['quantity'];
    }

    $opartion = ''; // لم تعد ضرورية إذا غيرت نظام الكابتشا

    if (request()->root() == 'https://digitalzone-qa.store' || request()->root() == 'https://digitalzon-qa.store') {
        return view('frontend.edit_cart', compact('cart', 'totalPrice', 'opartion', 'token'));
    }

    return view('frontend.cart', compact('cart', 'totalPrice', 'opartion', 'token'));
}

    public function index_new()
    {

        // Retrieve cart data from session

        $cart = session()->get('cart', []);

        // Calculate the total price of the cart
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        if (request()->root() == 'https://digitalzone-qa.store' ||  request()->root() == 'https://digitalzon-qa.store') {
            return view('frontend.edit_cart', compact('cart', 'totalPrice'));
        }
        // Return the cart view with cart items and total price
        return view('frontend.cart_new', compact('cart', 'totalPrice'));
    }
    public function store(Request $request)
    {
        // Assuming $product is the product object you want to add
        $product = Product::find($request->product_id);

        // Get the current cart from the session, or an empty array if not set
        $cart = session()->get('cart', []);

        // Check if the product already exists in the cart
        if (isset($cart[$product->id])) {
            // If it exists, increase the quantity by 1
            $cart[$product->id]['quantity'] += $request->qnt;
        } else {
            // If it doesn't exist, add the product to the cart
            $cart[$product->id] = [
                'name' => $product->name,
                'quantity' => $request->qnt,
                'price' => $product->price - $product->discount,
                'id' => $product->id,
            ];
        }

        // Update the cart in the session
        session()->put('cart', $cart);

        return redirect()->back()->with('success_add', 'تم إضافة المنتج إلى السلة!');
    }

    public function remove(Request $request)
    {
        // Retrieve the itemKey (product ID) from the request
        $itemKey = $request->input('itemKey');

        // Retrieve cart data from session
        $cart = session()->get('cart', []);

        // Check if the item exists in the cart
        if (isset($cart[$itemKey])) {
            // Remove the item from the cart
            unset($cart[$itemKey]);

            // Save the updated cart back to the session
            session()->put('cart', $cart);
        }

        // Redirect back to the cart page with a success message
        return redirect()->route('cart.index')->with('success_delete', 'تم حذف المنتج من السلة بنجاح!');
    }
    public function send_data(Request $request)
    {
        $key = 'submit|' . $request->ip();

        // حد لمحاولات الإرسال
        if (RateLimiter::tooManyAttempts($key, 10)) {
            return back()->with('error', 'محاولات كثيرة، حاول لاحقًا.');
        }

        // التحقق من الحقول الأساسية و CAPTCHA
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'whatsApp' => 'required',
            'address' => 'required|string',
            'payment_method' => 'required|string',
            'FirstPayment' => 'required|numeric',
            'InstallmentBy' => 'required|integer',
            'TotalPrice' => 'required|numeric',
            // honeypot
            'hp_field' => 'nullable',
            // CAPTCHA
            'captcha_answer' => 'required|string',
            'captcha_token' => 'required|string',
        ]);

        // honeypot للتحقق من الروبوتات
        if ($request->filled('hp_field')) {
            RateLimiter::hit($key);
            return back()->withInput()->with('error', 'محاولة مشبوهة.');
        }

        // التحقق من وجود token
        $token = $request->input('captcha_token');
        if (!session('captcha_token') || session('captcha_token') !== $token) {
            RateLimiter::hit($key);
            return back()->withInput()->with('error', 'رمز التحقق غير صحيح، أعد تحميل الصفحة.');
        }

        // التحقق من استخدام CAPTCHA مسبقًا
        if (session('captcha_used')) {
            RateLimiter::hit($key);
            return back()->withInput()->with('error', 'تم استخدام رمز التحقق هذه المرة.');
        }

        // التحقق من نص CAPTCHA
        $expectedText = session('captcha_text', '');
        $answer = strtoupper(preg_replace('/\s+/', '', $request->input('captcha_answer')));
        if ($answer !== strtoupper($expectedText)) {
            RateLimiter::hit($key);
            return back()->withInput()->with('error', 'إجابة التحقق غير صحيحة.');
        }

        // optional: التحقق من وقت استكمال النموذج
        $startTime = session('form_start_time') ?? now();
        $timeTaken = now()->diffInMilliseconds($startTime);
        

        // كل شيء جيد، تنظيف CAPTCHA ومحاولات الروبوت
        session(['captcha_used' => true]);
        session()->forget(['captcha_token', 'captcha_text', 'form_start_time']);
        RateLimiter::clear($key);

        // حفظ بيانات الطلب في الجلسة
        session([
            "name" => $request->input('name'),
            "email" => $request->input('email', 'none'),
            "phone" => $request->input('whatsApp'),
            "address" => $request->input('address'),
            "payment_method" => $request->input('payment_method'),
            "first_payment" => $request->input('FirstPayment'),
            "installment_by" => $request->input('InstallmentBy'),
            "totalPrice" => $request->input('TotalPrice')
        ]);

        // حساب الدفعة الشهرية
        $monthlyPayment = ($request->InstallmentBy > 0)
            ? ($request->TotalPrice - $request->FirstPayment) / $request->InstallmentBy
            : 0;

        session(["monthly_payment" => $monthlyPayment]);

        // إعادة التوجيه حسب طريقة الدفع
        switch ($request->payment_method) {
            case 'tappy':
                return redirect()->route('checkout.tappy');
            case 'tamara':
                return redirect()->route('checkout.tamara');
            case 'k-net':
            case 'knet':
                return redirect()->route('checkout.knet');
            default:
                return redirect()->route('pay');
        }
    }

    public function send_data_new(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'whatsApp' => 'required', // phone number
            'address' => 'required|string',
            'payment_method' => 'required|string',
            'FirstPayment' => 'required|numeric',
            'InstallmentBy' => 'required|integer',
            'TotalPrice' => 'required|numeric'
        ]);

        // Store data in session
        session(key: [
            "name" => $request->input('name'),
            "email" => 'none',
            "phone" => $request->input('whatsApp'),
            "address" => $request->input('address'),
            "payment_method" => $request->input('payment_method'),
            "first_payment" => $request->input('FirstPayment'),
            "installment_by" => $request->input('InstallmentBy'),
            "totalPrice" => $request->input('TotalPrice')
        ]);

        // Calculate monthly payment
        $monthlyPayment = ($request->InstallmentBy > 0)
            ? ($request->TotalPrice - $request->FirstPayment) / $request->InstallmentBy
            : 0;

        session(["monthly_payment" => $monthlyPayment]);

        // Redirect based on payment method
        if (
            $request->payment_method == 'tappy'
        ) {
            return redirect()->route('checkout.tappy');
        }

        if ($request->payment_method == 'tamara') {
            return redirect()->route('checkout.tamara');
        }
        if ($request->payment_method == 'k-net') {
            return redirect()->route('checkout.knet');
        }
        if ($request->payment_method == 'knet') {
            return redirect()->route('checkout.knet');
        }

        // Default redirect
        return redirect()->route('pay_new');
    }

    public function updateQuantity(Request $request)
    {
        $cart = session()->get('cart', []);

        $itemKey = $request->input('itemKey');
        $quantity = $request->input('quantity');

        if (isset($cart[$itemKey])) {
            // تحديث الكمية في السلة
            $cart[$itemKey]['quantity'] = $quantity;

            // تحديث السلة في الـ session
            session()->put('cart', $cart);
        }

        // حساب المجموع
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'status' => 'success',
            'totalPrice' => $totalPrice,
            'cart' => $cart,
        ]);
    }
    public function pay(Request $request)
    {
        $cart = session()->get('cart', []);
        $productCount = array_sum(array_column($cart, 'quantity'));
        $payment_method = session()->get('payment_method', '');
        $monthly_payment = session()->get('monthly_payment', 0);
        $first_payment = session()->get('first_payment', 0);
        $installment_by = session()->get('installment_by', 0);
        $totalPrice = session()->get('totalPrice', 0);
        // Calculate the total price of the cart
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        return view('frontend.pay', compact('totalPrice', 'cart', 'payment_method', 'monthly_payment', 'first_payment', 'installment_by', 'productCount'));
    }
    public function pay_new(Request $request)
    {
        $cart = session()->get('cart', []);
        $productCount = array_sum(array_column($cart, 'quantity'));
        $payment_method = session()->get('payment_method', '');
        $monthly_payment = session()->get('monthly_payment', 0);
        $first_payment = session()->get('first_payment', 0);
        $installment_by = session()->get('installment_by', 0);
        $totalPrice = session()->get('totalPrice', 0);
        // Calculate the total price of the cart
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        return view('frontend._pay', compact('totalPrice', 'cart', 'payment_method', 'monthly_payment', 'first_payment', 'installment_by', 'productCount'));
    }
    public function send_pay(Request $request) {}
    public function generateToken()
    {
        $text = Str::upper(Str::random(5)); // 5 أحرف عشوائية
        $token = Str::random(20); // Token للحماية

        Session::put('captcha_text', $text);
        Session::put('captcha_token', $token);
        Session::put('captcha_used', false);

        return response()->json([
            'token' => $token,
        ]);
    }

    // توليد صورة CAPTCHA ديناميكية
    public function image(Request $request)
{
    // نضمن أن النص تم توليده
    $text = Session::get('captcha_text', 'ERROR');

    $width = 150;
    $height = 50;

    $image = imagecreatetruecolor($width, $height);

    // خلفية رمادية فاتحة
    $bgColor = imagecolorallocate($image, 240, 240, 240);
    imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);

    // خطوط تشويش
    for ($i = 0; $i < 5; $i++) {
        $lineColor = imagecolorallocate($image, rand(150, 200), rand(150, 200), rand(150, 200));
        imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $lineColor);
    }

    // كتابة النص
    $textColor = imagecolorallocate($image, 0, 0, 0);
    $fontSize = 5;
    $x = 20;
    $y = 18;

    for ($i = 0; $i < strlen($text); $i++) {
        imagestring($image, $fontSize, $x + ($i * 20), $y + rand(-5, 5), $text[$i], $textColor);
    }

    ob_start();
    imagepng($image);
    $contents = ob_get_clean();
    imagedestroy($image);

    return response($contents)->header('Content-Type', 'image/png');
}

}
