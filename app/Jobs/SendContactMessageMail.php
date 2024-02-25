<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use App\Mail\ContactMessageMarkdownMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendContactMessageMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $mailable;
    /**
     * Create a new job instance.
     */
    public function __construct(ContactMessageMarkdownMail $mailable)
    {
        $this->mailable = $mailable;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Mail::to('pret@Noreply.com')->send($this->mailable);
    }
}
