<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\ValideMarkdownMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendValideMarkdownMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $vmailable;
    protected $email;
    /**
     * Create a new job instance.
     */
    public function __construct(ValideMarkdownMail $vmailable, $email)
    {
        $this->vmailable = $vmailable;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send($this->vmailable);
    }
}
