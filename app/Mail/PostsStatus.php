<?php

namespace App\Mail;

use App\Models\Publication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostsStatus extends Mailable
{
    use Queueable, SerializesModels;

    public $publication;
    public $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Publication $publication, $status)
    {
        $this->publication = $publication;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        return $this->markdown('emails.posts.status');
        return $this->subject('IFG.TV - '.$this->status)
                    ->markdown('emails.posts.status'
                        , [
                            'url' => route('publications.show', $this->publication->id),
                        ]);
    }
}
