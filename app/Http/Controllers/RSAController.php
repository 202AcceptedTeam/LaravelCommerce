<?php

namespace App\Http\Controllers;


use App\Http\Helper\RSA as RSAKEY;
use Illuminate\Http\Request;

class RSAController extends Controller
{
    //
    public function index($plaintext){
        $help = new RSAKEY();
        return $help::encryp_rsa('RCK-LKJ',$plaintext);
    }
}
