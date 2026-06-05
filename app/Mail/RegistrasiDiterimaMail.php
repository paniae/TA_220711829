<?php

namespace App\Mail;

use App\Models\Pengguna;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrasiDiterimaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengguna;

    /**
     * Create a new message instance.
     */
    public function __construct(Pengguna $pengguna)
    {
        $this->pengguna = $pengguna;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('🎉 Pendaftaran Akun Berhasil Diterima - Padukuhan')
                    ->view('emails.registrasi_diterima');
    }
}
