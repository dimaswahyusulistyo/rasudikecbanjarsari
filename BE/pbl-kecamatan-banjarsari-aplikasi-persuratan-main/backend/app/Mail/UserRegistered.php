<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $username;
    public $password;
    public $email;

    /**
     * Create a new message instance.
     *
     * @param string $username
     * @param string $password
     * @param string $email
     */
    public function __construct($username, $password, $email)
    {
        $this->username = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
        $this->password = htmlspecialchars($password, ENT_QUOTES, 'UTF-8');
        $this->email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Pendaftaran Berhasil')
                    ->view('emails.user_registered')
                    ->with([
                        'username' => $this->username,
                        'password' => $this->password,
                        'email' => $this->email,
                    ]);
    }
}
