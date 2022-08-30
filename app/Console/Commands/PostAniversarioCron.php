<?php

namespace App\Console\Commands;

use App\Models\Birthday;
use App\Models\Publication;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class PostAniversarioCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:aniversario';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gerar post de aniversariantes do dia';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $birthdays = Birthday::whereDay('birthday', now()->day)
            ->whereMonth('birthday', now()->month)
            ->get();

        foreach ($birthdays as $birthday) {
            //nova publicação de aniversário

            Carbon::setlocale('pt_BR');

            $publication = new Publication();
            $publication->titulo = 'Feliz Aniversário<br>' . $birthday->birthday->translatedFormat('l\, j \de F');
            $publication->texto = '<p style="text-align: center; "><b><i>' . $birthday->name . '</i></b>, o IFG Câmpus Jataí deseja que você tenha um feliz aniversário.</p>';
            $publication->tipo = 'texto';
            $publication->imagem = 'aniversario';
            $publication->status = 3;
            $publication->publicado = 1;
            $publication->user_id = 1;

            //saber se o aniversario é sabado ou domingo
            $dayOfWeek = $birthday->birthday->dayOfWeek;
            if ($dayOfWeek == Carbon::SATURDAY) {
                $publication->data_expiracao = $birthday->birthday->addDay(2);
            } elseif ($dayOfWeek == Carbon::SUNDAY) {
                $publication->data_expiracao = $birthday->birthday->addDay(1);
            } else {
                $publication->data_expiracao = $birthday->birthday;
            }

            $publication->data_publicacao = Carbon::now();

            $publication->save();

            Log::info('Post de aniversário gerado para ' . $birthday->name);
        }

        Log::info('Qtd. de aniversariantes do dia: ' . $birthdays->count());

        return 0;

    }
}
