<?php

namespace App\Console\Commands;

use App\Models\Borrow;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Throwable;

class MarkOverdueBorrow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mark-overdue-borrow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Memperbarui status peminjaman menjadi Overdue jika sudah memasuki hari jatuh tempo peminjaman';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $updated = Borrow::whereIn('status', ['confirmed', 'extend'])
                ->whereDate('due_date', '<', Carbon::today())
                ->update(['status' => 'overdue']);
            $this->info("Berhasil update {$updated} peminjaman menjadi overdue.");
            return 0;
        } catch (Throwable $e) {
            Log::error('SendDueBookReminder failed: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            throw $e;
        }
    }
}
