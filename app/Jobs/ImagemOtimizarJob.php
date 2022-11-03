<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use ImageOptimizer;

class ImagemOtimizarJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $imagem;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($imagem)
    {
        $this->imagem = $imagem;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //otimizar para webp
        $pathToImage = public_path('publish/tv/'. $this->imagem .'.webp');
        ImageOptimizer::optimize($pathToImage);

        Log::info('Imagem otimizada: ' . $this->imagem);
    }
}
