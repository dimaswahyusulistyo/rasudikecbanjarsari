<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Sanctum\PersonalAccessToken;
use Carbon\Carbon;

class DeleteExpiredTokens extends Command
{
    protected $signature = 'tokens:delete-expired';
    protected $description = 'Delete expired API tokens';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();
        $expiredTokens = PersonalAccessToken::where('expires_at', '<', $now)->delete();

        $this->info("Deleted $expiredTokens expired tokens.");
    }
}
