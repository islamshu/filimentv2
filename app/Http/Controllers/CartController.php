<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // تأكد أنك مستورد المنتج

class CartController extends Controller
{
    public function index()
    {

        // Retrieve cart data from session

        $cart = session()->get('cart', []);

        // Calculate the total price of the cart
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }
        dd(url()->current());
        if (url()->current() == 'https://digitalzone-qa.store') {
            dd('f');
            // الكود الذي تريد تنفيذه إذا كان رابط الموقع هو https://example.com
            return view('frontend.edit_cart', compact('cart', 'totalPrice'));
        }
        // Return the cart view with cart items and total price
        return view('frontend.cart', compact('cart', 'totalPrice'));
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
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'whatsApp' => 'required', // phone number
            'address' => 'required|string',
            'payment_method' => 'required|string',
            'FirstPayment' => 'required|numeric',
            'InstallmentBy' => 'required|integer',
            'TotalPrice' => 'required|numeric'
        ]);

        // Store data in session
        session([
            "name" => $request->input('name'),
            "email" => $request->input('email'),
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
        if ($request->payment_method == 'tappy') {
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
        return redirect()->route('pay');
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
    public function send_pay(Request $request) {}
}
