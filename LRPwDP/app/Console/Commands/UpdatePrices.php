<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Perishable;

class UpdatePrices extends Command
{
    // The command name you will run in terminal
    protected $signature = 'ml:update-prices';

    // Description for "php artisan list"
    protected $description = 'Fetch predicted prices from AI API and update perishables';

    public function handle()
    {
        $this->info('Starting AI Price Update...');

        // Optimization: Use chunk() to handle large datasets without running out of memory
        Perishable::where('status', 1)->chunk(100, function ($perishables) {
            foreach ($perishables as $item) {
                try {
                    $hoursToExpiry = now()->diffInHours($item->expiryDate, false);

                    $response = Http::post('http://127.0.0.1:5000/predict-price', [
                        "ExpiryHours"   => $hoursToExpiry,
                        "Quantity"      => $item->quantity,
                        "TotalQuantity" => $item->quantityOriginal,
                        "OriginalPrice" => $item->priceOriginal,
                        "LowerBound"    => $item->priceLowerBound,
                        "Weekday"       => now()->dayOfWeek,
                        "city"          => $item->user->city ?? 'Unknown',
                    ]);

                    if ($response->successful()) {
                        $item->update(['priceCurrent' => $response['new_price']]);
                        $this->info("Updated Item ID: {$item->id}"); // Output to terminal
                    }
                } catch (\Exception $e) {
                    Log::error("AI price update FAILED ID {$item->id}: {$e->getMessage()}");
                    $this->error("Failed ID {$item->id}");
                }
            }
        });

        $this->info('AI Price Update Complete.');
    }
}