<?php

namespace App\Jobs;

use App\Http\Controllers\DemandeController;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use App\Mail\DemandeReceiptMarkdownMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendDemandeReceiptMarkdownMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $dmailable;
    protected $email;
    /**
     * Create a new job instance.
     */
    public function __construct(DemandeReceiptMarkdownMail $dmailable, $email)
    {
        $this->dmailable = $dmailable;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Mail::to($this->email)->send($this->dmailable);
    }
}
