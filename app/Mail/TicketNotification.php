<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Ticket;

class TicketNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $tickets;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tickets, array $validated)
    {
        $this->tickets = $tickets;
        $this->validated = $validated;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('ticket.mail')
                    ->with([
                        'tickets' => $this->tickets,
                        'validated' => $this->validated,
                    ]);
    }
}
