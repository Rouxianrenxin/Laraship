<?php

namespace Corals\Modules\Newsletter\Mail;

use Corals\Modules\Newsletter\Models\EmailLogger;
use Corals\Modules\Newsletter\Models\Email;
use Corals\Modules\Newsletter\Models\Subscriber;
use Corals\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsletterEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $email, $api_call_id;

    /**
     * NewsletterEmail constructor.
     * @param Email $email
     * @param $api_call_id
     */
    public function __construct(Email $email, $api_call_id)
    {
        $this->email = $email;
        $this->api_call_id = $api_call_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from(user()->email)
            ->subject($this->email->subject)
            ->view('Newsletter::mails.newsletter_email')
            ->with([
                'body' => $this->email->email_body,
            ]);
    }
}
