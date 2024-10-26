<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $to;
    public $subject;
    public $view;
    public $data;
    public $attachments;

    public $tries = 5;
    public $backoff = 60; // seconds

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $subject, $view, $data, $attachments = null)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->view = $view;
        $this->data = $data;
        $this->attachments = $attachments;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send($this->view, $this->data, function ($message) {
            $message->to($this->to)
                ->subject($this->subject);

            if ($this->attachments) {
                foreach ($this->attachments as $attachment) {
                    $message->attach($attachment['path'], [
                        'as' => $attachment['name'] ?? null,
                        'mime' => $attachment['mime'] ?? null,
                    ]);
                }
            }
        });
    }
}
