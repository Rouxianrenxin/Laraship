<?php

namespace Corals\Modules\Ecommerce\Mails;

use Corals\Modules\Ecommerce\Models\Order;
use Corals\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderUpdatedEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $body, $subject, $order;

    /**
     * OrderReceivedEmail constructor.
     * @param User $user
     * @param $order
     * @param null $subject
     * @param null $body
     */
    public function __construct( Order $order, $subject = null, $body = null)
    {
        $this->order = $order;
        $this->body = $body;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->view('Ecommerce::mails.order_details');
    }
}
