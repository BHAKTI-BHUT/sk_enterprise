<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\User;
use App\Notifications\LowStockNotification;
use Illuminate\Support\Facades\Notification;

class TestLowStockNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:low-stock-notification {product_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simulates a low stock scenario and triggers the Low Stock Notification to admins';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $productId = $this->argument('product_id');

        if ($productId) {
            $product = Product::find($productId);
            if (!$product) {
                $this->error("Product with ID {$productId} not found.");
                return;
            }
        } else {
            // Pick a random product or first product
            $product = Product::first();
            if (!$product) {
                $this->error("No products found in the database. Please add a product first.");
                return;
            }
        }

        $admin = User::role('admin')->first() ?? User::first();

        if (!$admin) {
            $this->error("No admin or user found in the database to send the notification to.");
            return;
        }

        $this->info("Found Admin: {$admin->name} ({$admin->email})");
        $this->info("Simulating low stock for product: {$product->name}");
        $this->info("Current Stock: {$product->stock_quantity}, Min Threshold: {$product->min_stock_alert}");
        
        $this->line("Triggering notification...");

        Notification::send($admin, new LowStockNotification($product));

        $this->info("✅ Notification successfully queued/sent to database and mail!");
        $this->line("You can safely check your email testing tool and your dashboard header layout.");
    }
}
