<?php

namespace App\Mail;

use App\Models\KegiatanPadukuhan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KegiatanBaruMail extends Mailable
{
    use Queueable, SerializesModels;

    public $kegiatan;

    /**
     * Create a new message instance.
     */
    public function __construct(KegiatanPadukuhan $kegiatan)
    {
        $this->kegiatan = $kegiatan;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $tipe = $this->kegiatan->jenis_kegiatan === 'proker' ? 'Program Kerja Baru' : 'Kegiatan Baru';
        return $this->subject('🔔 ' . $tipe . ': ' . $this->kegiatan->nama_kegiatan)
                    ->view('emails.kegiatan_baru');
    }
}
