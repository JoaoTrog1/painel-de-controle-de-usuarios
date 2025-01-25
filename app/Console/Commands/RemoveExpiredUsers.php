<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class RemoveExpiredUsers extends Command
{
    /**
     * O nome e a assinatura do console command.
     *
     * @var string
     */
    protected $signature = 'users:remove-expired';

    /**
     * A descrição do comando.
     *
     * @var string
     */
    protected $description = 'Remove usuários com validade expirada há mais de 10 dias';

    /**
     * Executar o comando.
     *
     * @return void
     */
    public function handle()
    {
        $expiredUsers = User::where('validade', '<', \Carbon\Carbon::now()->subDays(10))->get();


        if ($expiredUsers->isEmpty()) {
            $this->info('Não há usuários expirados.');
        } else {
            foreach ($expiredUsers as $user) {
                $user->delete();
                $this->info("Usuário {$user->name} removido.");
            }
        }
    }
}
