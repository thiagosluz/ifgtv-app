<?php

namespace App\Jobs;

use App\Mail\PostsStatus;
use App\Models\Publication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $status;
    protected $publication;
    protected $recipient;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Publication $publication ,$status, $recipient)
    {
        $this->status = $status;
        $this->publication = $publication;
        $this->recipient = $recipient;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->recipient)->send(new PostsStatus($this->publication, $this->status));
    }
}
