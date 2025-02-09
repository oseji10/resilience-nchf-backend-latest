<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

      /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $firstName, $lastName, $defaultPassword, $languageId)
    {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->defaultPassword = $defaultPassword;
        $this->languageId = $languageId;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.welcome-email')
                    ->subject('User Enrolment - National Cancer Health Fund')
                    ->with([
                        'email' => $this->email,
                        'firstName' => $this->firstName,
                        'lastName' => $this->lastName,
                        
                        'defaultPassword' => $this->defaultPassword,
                        'languageId' => $this->languageId,
                        'action_url' => "https://nchf.resilience.ng/login",
                        'login_url' => "https://nchf.resilience.ng/login",
                        
                        'support_email' => "info@resilience.ng",
                    ]);
    }
}
