<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PresupuestoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $datos;
    public $archivo;

    /**
     * Create a new message instance.
     */
    public function __construct($datos)
    {
        $this->datos = $datos;
        $this->archivo = $datos['archivo'] ?? null;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $mail = $this->subject('Nuevo Presupuesto Web')
            ->view('emails.presupuesto')
            ->with(['datos' => $this->datos]);

        if (isset($this->datos['archivo']) && $this->datos['archivo'] instanceof \Illuminate\Http\UploadedFile) {
            $mail->attach($this->datos['archivo']->getRealPath(), [
                'as' => $this->datos['archivo']->getClientOriginalName(),
                'mime' => $this->datos['archivo']->getMimeType(),
            ]);
        }

        return $mail;
    }
}
