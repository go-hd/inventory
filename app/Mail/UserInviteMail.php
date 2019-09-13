<?php

namespace App\Mail;

use App\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserInviteMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;
    protected $token;
    protected $company;

    /**
     * UserInviteMail constructor.
     *
     * @param string $email
     * @param string $token
     * @param Company $company
     */
    public function __construct(string $email, string $token, Company $company)
    {
        $this->email = $email;
        $this->token = $token;
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("【inventory】{$this->company->name}から招待が届いています")
            ->view('mails.user_invite')
            ->with(['company' => $this->company, 'email' => $this->email, 'token' => $this->token]);
    }
}
