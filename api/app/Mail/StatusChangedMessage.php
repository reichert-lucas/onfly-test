<?php

namespace App\Mail;

use App\Enum\TravelOrderStatusEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatusChangedMessage extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected string $name;
    protected int $statusId;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $name, int $statusId)
    {
        $this->name = $name;
        $this->statusId = $statusId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        switch ($this->statusId) {
            case TravelOrderStatusEnum::APPROVED->value:
                $sucbject = 'Seu pedido de viagem foi aprovado';
                $content = "Olá {$this->name}, viemos por meio desse email informar que seu pedido de viagem foi atualizado para <b>APROVADO</b>!";
                break;

            case TravelOrderStatusEnum::CANCELLED->value:
            default:
                $sucbject = 'Seu pedido de viagem foi cancelado';
                $content = "Olá {$this->name}, viemos por meio desse email informar que seu pedido de viagem foi atualizado para <b>CANCELADO</b>!";
                break;
        }
    
        return $this->subject($sucbject)
                    ->view('mails.travel-orders.status-changed')
                    ->with([
                        'content' => $content,
                    ]);
    }
}
