<?php

namespace App\Mail;

use App\Models\Pengguna;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PendaftaranBaruMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pendaftar;

    /**
     * Create a new message instance.
     */
    public function __construct(Pengguna $pendaftar)
    {
        $this->pendaftar = $pendaftar;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('🔔 Pendaftaran Akun Baru Perlu Konfirmasi: ' . $this->pendaftar->nama)
                    ->view('emails.pendaftaran_baru');
    }
}
