<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product; // تأكد أنك مستورد المنتج
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
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
        $validated = $request->validate([
            'name' => 'required|string',
            'phone1' => 'required',
            'phone2' => 'nullable',
            'whatsapp' => 'required',
            'address' => 'required|string',
            'notes' => 'nullable|string',

            'payment_method' => 'required|string',
            'FirstPayment' => 'required|numeric',
            'TotalPrice' => 'required|numeric',

        ]);

        session([
            "name" => $request->input('name'),
            "phone1" => $request->input('phone1'),
            "phone2" => $request->input('phone2'),
            "whatsapp" => $request->input('whatsapp'),
            "address" => $request->input('address'),
            "notes" => $request->input('notes'),
            "payment_method" => $request->input('payment_method'),
            "first_payment" => $request->input('FirstPayment'),
            "installment_by" => $request->input('InstallmentBy'),
            "totalPrice" => $request->input('TotalPrice'),
        ]);

    
        $order_code = now()->timestamp . rand(1000, 9999);

  
        $order = Order::create([
            'code' => $order_code,
            'name' => $request->name,
            'phone' => $request->phone1,
            'phone2' => $request->phone2,
            'location'=>$request->address,
            'payment' => $request->TotalPrice,
            'first_batch' => $request->FirstPayment,
            'payment_getway' => 'all',
            'note'=>$request->notes,
            'whatsapp'=>$request->whatsapp,
            'order_currancy'=>get_currancy()
        ]);
        add_detiles($order);

        if (!$order) {
            return redirect('/');
        }

   $message = ":: طلب جديد ::" . PHP_EOL
    . "رقم الطلب: " . $order->code . PHP_EOL
    . "الاسم: " . $order->name . PHP_EOL
    . "رقم الهاتف: " . $order->phone . PHP_EOL
    . "رقم هاتف 2: " . $order->phone2 . PHP_EOL
    . "واتساب: " . $order->whatsapp . PHP_EOL
    . "العنوان: " . $order->location . PHP_EOL

    . "المبلغ الإجمالي: " . $order->payment . PHP_EOL
    // . "الدفعة الأولى: " . $order->first_batch . PHP_EOL
    . "طريقة الدفع: عند الاستلام" . PHP_EOL
    . "ملاحظات: " . $order->note . PHP_EOL

    . ":: روابط مهمة ::" . PHP_EOL
    // . "لوحة التحكم: " . url('/admin/orders/' . $order->id) . PHP_EOL
    . "فاتورة: " . route('invoice.show', $order->id) . PHP_EOL
    // . "عقد: " . route('invoice.contact', $order->code) . PHP_EOL
    . "واتساب مباشر: https://wa.me/" . preg_replace('/[^0-9]/', '', $order->phone) . PHP_EOL;
 $key = env('TOKEN_TELEGRAM');
        $ids = env('TELEGRAM_CHAT_ID');

        // Prepare request data
        $url_new = "https://api.telegram.org/bot" . $key . "/sendMessage";
        $senderr = [
            'chat_id' => $ids,
            'text' => $message,
        ];

        $curll_new = curl_init($url_new);
        curl_setopt($curll_new, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curll_new, CURLOPT_POST, true);
        curl_setopt($curll_new, CURLOPT_POSTFIELDS, $senderr);
        $response = curl_exec($curll_new);

        session()->forget('cart');
        session()->forget('order_data');
        return redirect()->route('success_new_payment',$order->code);
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
    public function success_new_payment($code)
    {
         $order = Order::where("code",$code)->first();

        return view('frontend.success_new_payment')->with('order', $order);
    }
}