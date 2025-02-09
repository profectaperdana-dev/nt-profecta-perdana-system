<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $data;
    protected $warehouse;
    public function __construct($warehouse, $data)
    {
        $this->data = $data;
        $this->warehouse = $warehouse;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('purchase_orders.mail_po')
            ->from('noreply@profectaperdana.com', 'PROFECTA PERDANA')
            ->subject('PURCHASE ORDER ' . $this->data->order_number)
            ->with(['data' => $this->data, 'warehouse' => $this->warehouse])
            ->attach(public_path('pdf/' . $this->data->order_number . '.pdf'));
    }
}
