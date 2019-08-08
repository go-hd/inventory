<?php

namespace App\Mail;

use App\UserVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserVerifyMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $userVerification;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserVerification $userVerification)
    {
        $this->userVerification = $userVerification;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("【inventory】{$this->userVerification->company->name}から招待が届いています")
            ->view('mails.user_verify')
            ->with(['userVerification' => $this->userVerification]);
    }
}
