<?php

namespace App\Http\Helper;

use phpseclib\Crypt\RSA as Crypt_RSA;

class RSA { 
    public static function encryp_rsa($publickey = 'bla-123-bla',$plaintext){
        $rsa = new Crypt_RSA();
        $rsa->loadKey($publickey);
        $rsa->setEncryptionMode(2);
        $data = $plaintext;
        $output = $rsa->encrypt($data);
        return base64_encode($output);
    }
}