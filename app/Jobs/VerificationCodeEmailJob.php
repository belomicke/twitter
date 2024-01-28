<?php

namespace App\Jobs;

use App\Mail\Account\VerificationCodeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class VerificationCodeEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected string $email,
        protected int $code
    ) {}

    public function handle(): void
    {
        Mail::to($this->email)
            ->send(new VerificationCodeMail(
                code: $this->code
            ));
    }
}
