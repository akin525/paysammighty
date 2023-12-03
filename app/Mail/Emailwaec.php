<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Emailwaec extends Mailable
{
    use Queueable, SerializesModels;
    protected $waec;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($waec)
    {
        $this->waec = $waec;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $waec= $this->waec;
        return $this->markdown('email.waec',['bo' => $waec])->subject(   $waec['username'].' |WAEC-PIN|'.'Amazing-Data');
    }
}
