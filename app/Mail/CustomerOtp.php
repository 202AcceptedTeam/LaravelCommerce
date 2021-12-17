<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Customer; 

class CustomerOtp extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $customer;
    protected $otp;
    public function __construct(Customer $customer, $otp)
    {
        $this->customer = $customer;
        $this->otp = $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Verifikasi Pendaftaran Anda')
            ->view('emails.register')
            ->with([
                'customer' => $this->customer,
                'otp' => $this->otp
            ]);
    }
}
