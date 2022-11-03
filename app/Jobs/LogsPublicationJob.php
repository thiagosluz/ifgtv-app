<?php

namespace App\Jobs;

use App\Models\History;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class LogsPublicationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $publication;
    protected $action;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($publication, $user, $action)
    {
        $this->publication = $publication;
        $this->action = $action;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $history = new History();
        $history->user_id = $this->user;
        $history->publication_id = $this->publication;
        $history->action = $this->action;
        $history->save();
        Log::info('Log de publicação criado com sucesso!');
    }
}
