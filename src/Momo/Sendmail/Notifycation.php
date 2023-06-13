<?php

namespace Service\Payment\Momo\Sendmail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Notifycation extends Mailable
{
    use Queueable, SerializesModels;

    public $error;

    /**
     * Create a new message instance.
     *
     * @param  string  $error
     * @return void
     */
    public function __construct($error)
    {
        $this->error = $error;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Payment Failed')
            ->view('payment::sendmail')
            ->with(['error' => $this->error]);
    }
}
