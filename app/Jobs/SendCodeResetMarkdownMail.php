<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\CodeResetMarkdownMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendCodeResetMarkdownMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $cmailable;
    public $email;
    /**
     * Create a new job instance.
     */
    public function __construct(CodeResetMarkdownMail $cmailable, $email)
    {
        $this->cmailable = $cmailable;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        Mail::to($this->email)->send($this->cmailable);
    }
}
