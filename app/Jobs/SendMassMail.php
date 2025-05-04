<?php

namespace App\Jobs;

use App\Mail\MassMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMassMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $emails;
    protected $content;

    public function __construct($emails, $content)
    {
        $this->emails = $emails;
        $this->content = $content;
    }

    public function handle()
    {
        foreach ($this->emails as $email) {
            dd($this->emails);
            Mail::to($email)->send(new MassMail($this->content));
        }
    }
}
