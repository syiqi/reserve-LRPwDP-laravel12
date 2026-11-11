<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Perishable;

class UpdateExpiredPerishables extends Command
{
    protected $signature = 'perishables:prune';
    protected $description = 'Mark items past their expiry date as inactive';

    public function handle()
    {
        $count = Perishable::where('status', 1)
            ->where('expiryDate', '<', now())
            ->update(['status' => 0]);

        $this->info("Expired {$count} perishable items.");
    }
}