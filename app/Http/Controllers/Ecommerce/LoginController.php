<?php

namespace App\Http\Controllers\Ecommerce;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\Mail\CustomerOtp;
use Mail;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function loginForm()
    {
        
        if (auth()->guard('customer')->check()) return redirect(route('customer.dashboard'));
        return view('ecommerce.login');
    }
    public function otpform($email)
    {
        if (auth()->guard('customer')->check()) return redirect(route('customer.dashboard'));
        return view('ecommerce.loginformotp',['email' => $email]);
    }

    public function loginWithOtp(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        
        $auth = $request->only('email', 'password');
        
        // view('eccommerce.loginformotp',['auth' => $auth]);
        if ($this->isUser($auth) == true) {
            $this->sendOtp($auth['email']);
            return redirect()->route('customer.login_otp',$request->email)->with('auth', $auth);
        }

        return redirect()->back()->with(['error' => 'Email / Password Salah']);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'otp' => 'required'
        ]);
        // $auth = Customer::where('email',$request->email)->pluck('email','otp')->toArray();
        $auth = $request->only(['email','password','otp']);
        $auth['status'] = 1;
        if (auth()->guard('customer')->attempt($auth)) {
            $this->afterValidate($auth['email']);
            return redirect()->intended(route('customer.dashboard'));
        }

        return redirect()->back()->with(['error' => 'Kode OTP Tidak ditemukan','auth' => $auth]);
    }

    public function sendOtp($email){

        $otp = rand(1000,9999);
        $customer = Customer::where('email',$email)->first();
        $customer->otp = $otp;
        $customer->save();
        Mail::to($customer->email)->send(new CustomerOtp($customer, $otp));
    }

    private function isUser($auth){
        if(Customer::where([
            ['email', '=', $auth['email']],
            ['password', '=', $auth['password']]
        ])->get()){
            return true;
        }
        return false;
    }

    private function validateOtp($auth){
        if(Customer::where([
            ['email', '=', $auth['email']],
            ['otp', '=', $auth['otp']]
        ])->count() > 0){
            return true;
        }
        return false;
    }
    private function afterValidate($email){
        $user = Customer::where('email',$email)->first();
        $user->otp = null;
        $user->save();
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
