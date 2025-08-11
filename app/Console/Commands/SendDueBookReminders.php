<?php

namespace App\Console\Commands;

use App\Jobs\SendDueBookReminder;
use App\Models\Borrow;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendDueBookReminders extends Command
{
    protected $signature = 'reminder:due-books';
    protected $description = 'Kirim WA otomatis jika buku jatuh tempo';

    public function handle()
    {
        try {
            $borrows = Borrow::with('user', 'book')->where('status', 'overdue')->get();
            $due_format = null;

            foreach ($borrows as $borrow) {
                // Cek user dan book ada
                if (!$borrow->user || !$borrow->book) {
                    continue;
                }
                $due_format = Carbon::parse($borrow->due_date)->diffForHumans();
                $borrowed_at_format = Carbon::parse($borrow->borrowed_at)->diffForHumans();

                $due_format_2 = Carbon::parse($borrow->due_date)->translatedFormat('l, d F Y');
                $borrowed_at_format_2 = Carbon::parse($borrow->borrowed_at)->translatedFormat('l, d F Y');
                Http::withToken(env('WHATSAPP_BOT_TOKEN'))->post(env('WHATSAPP_BOT_URL') . '/api/send-message', [
                    'phone_number' => $borrow->user->phone_number,
                    'message' => "> Layanan Chatbot Perpustakaan Umum Kota Solok\n> 🔔 Pengingat Pengambalian Otomatis\n\nHalo {$borrow->user->name}, peminjaman dengan data:\n\n- *{$borrow->book->physical_shape}* {$borrow->book->clean_title}\n- Dipinjam: {$borrowed_at_format}\n\nTelah jatuh tempo pada {$due_format}. Harap segera melakukan pengembalian.\n\n_Peminjaman: {$borrowed_at_format_2}_\n_Jatuh Tempo: {$due_format_2}_"
                ]);
            }

            $this->info("Berhasil mengirimkan notifikasi/pengingat buku jatuh tempo!");
        } catch (Throwable $e) {
            Log::error('SendDueBookReminder failed: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            throw $e;
        }
    }
}
