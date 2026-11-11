<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Reservation;
use App\Models\Perishable;

class UpdateExpiredReservations extends Command
{
    protected $signature = 'reservations:cancel-expired';
    protected $description = 'Cancel reservations past pickup time and restore inventory';

    public function handle()
    {
        $reservations = Reservation::where('status', 'reserved')
            ->where('pickupTime', '<', now())
            ->get();

        $count = 0;

        foreach ($reservations as $reservation) {
            try {
                if ($reservation->perishableID) {
                    $perishable = Perishable::find($reservation->perishableID);
                    
                    // Restore quantity if item is active
                    if ($perishable && $perishable->status == 1) {
                        $perishable->increment('quantity', $reservation->reserveQuantity);
                    }
                }

                $reservation->update(['status' => 'cancelled']);
                $count++;
                
            } catch (\Exception $e) {
                Log::error("Failed to cancel Reservation {$reservation->id}: {$e->getMessage()}");
            }
        }

        $this->info("Processed {$count} expired reservations.");
    }
}