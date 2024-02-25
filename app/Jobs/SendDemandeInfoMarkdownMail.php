<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\DemandeInfoMarkdownMail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendDemandeInfoMarkdownMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $nmailable;
    /**
     * Create a new job instance.
     */
    public function __construct(DemandeInfoMarkdownMail $nmailable)
    {
        $this->nmailable = $nmailable;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Mail::to('admin@Noreply.com')->send($this->nmailable);
    }
}
