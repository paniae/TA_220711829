<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProdukMasterBaruMail extends Mailable
{
    use Queueable, SerializesModels;

    public $produkMaster;
    public $pengaju;

    public function __construct($produkMaster, $pengaju)
    {
        $this->produkMaster = $produkMaster;
        $this->pengaju = $pengaju;
    }

    public function build()
    {
        return $this->subject('Pengajuan Produk Master Baru')
                    ->view('emails.produk_master_baru');
    }
}
