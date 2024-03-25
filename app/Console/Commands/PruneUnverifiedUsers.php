<?php

namespace App\Console\Commands;
use App\Models\User;

use Illuminate\Console\Command;

class PruneUnverifiedUsers extends Command
{

    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:prune-unverified-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete unverified users who did not verify their email within the specified time frame.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $timeFrame = now()->subMinutes(5);

        $unverifiedUsers = User::whereNull('email_verified_at')
            ->where('created_at', '<=', $timeFrame)
            ->get();

        foreach ($unverifiedUsers as $user) {
            $user->delete();
        }
        $this->info(count($unverifiedUsers) . ' unverified users deleted.');
    }
}
