<?php

namespace CreatyDev\Domain;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use CreatyDev\Domain\Company\Models\Company;


class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->data['subject'])->markdown('emails.forgotpassword');
        // return $this->from('example@example.com')->markdown('emails.forgotpassword');
        // return $this->view('emails.forgotpassword');
        // $this->subject($this->data['subject'])
        //             ->view('emails.forgotpassword')
        //             ->from('vmahumani@aolc.co.za');
    }
}
