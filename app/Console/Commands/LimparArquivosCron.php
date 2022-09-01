<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class LimparArquivosCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'limpar:arquivos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpando arquivos de imagens temporários';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $folderPath = public_path('publish/thumbnail');
        $apagar = File::deleteDirectory($folderPath);
        $criar = File::makeDirectory($folderPath, 0777, true, true);
        Log::info('Arquivos apagados e pasta criada: ' . $folderPath);
        return 0;
    }
}
