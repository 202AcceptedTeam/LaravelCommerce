<?php

namespace App\Http\Controllers\Ecommerce;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\Mail\CustomerOtp;
use Mail;

class LoginController extends Controller
{
    public function loginForm($username,$password)
    {
        $auth = ['username' => $username,'password' => $password];
        if (auth()->guard('customer')->check()) return redirect(route('customer.dashboard'));
        return view('ecommerce.login',['auth' => $auth]);
    }
    public function otpform()
    {
        if (auth()->guard('customer')->check()) return redirect(route('customer.dashboard'));
        return view('ecommerce.loginformotp');
    }

    public function loginWithOtp(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $auth = $request->only('email', 'password');
        $auth['status'] = 1; 
    
        return redirect()->route('customer.login_otp')->with(['auth' => $auth]);
        // view('eccommerce.loginformotp',['auth' => $auth]);
        // if (auth()->guard('customer')->attempt($auth)) {
        //     return redirect()->intended(route('customer.dashboard'));
        // }

        // return redirect()->back()->with(['error' => 'Email / Password Salah']);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $auth = $request->only('email', 'password', 'otp');
        $auth['status'] = 1; 
    
        if (auth()->guard('customer')->attempt($auth)) {
            return redirect()->intended(route('customer.dashboard'));
        }

        return redirect()->back()->with(['error' => 'Email / Password Salah']);
    }

    public function sendOtp($email,$otp){

        $otp = rand(1000,9999);
        $customer = Customer::where('email',$email)->first();
        Mail::to($customer->email)->send(new CustomerOtp($customer, $otp));
    }

    public function dashboard()
    {
        //Terdapat kondisi dengan menggunakan CASE, dimana jika kondisinya terpenuhi dalam hal ini status 
        //maka subtotal akan di-sum, kemudian untuk shipping dan complete hanya di count order

        $orders = Order::selectRaw('COALESCE(sum(CASE WHEN status = 0 THEN subtotal + cost END), 0) as pending, 
        COALESCE(count(CASE WHEN status = 3 THEN subtotal END), 0) as shipping,
        COALESCE(count(CASE WHEN status = 4 THEN subtotal END), 0) as completeOrder')
        ->where('customer_id', auth()->guard('customer')->user()->id)->get();

        return view('ecommerce.dashboard', compact('orders'));
    }

    public function logout()
    {
        auth()->guard('customer')->logout(); 
        return redirect(route('customer.login'));
    }
}
