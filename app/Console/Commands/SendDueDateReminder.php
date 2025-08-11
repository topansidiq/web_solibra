<?php

namespace App\Console\Commands;

use App\Models\Borrow;
use App\Services\WhatsAppBotService;
use Illuminate\Console\Command;
use App\Models\Loan;
use App\Services\WhatsappService;
use Carbon\Carbon;

class SendDueDateReminder extends Command
{
    protected $signature = 'reminder:due-date-book';
    protected $description = 'Kirim WA jika buku jatuh tempo 3, 2, atau 1 hari lagi';

    public function handle(WhatsAppBotService $wa)
    {
        $today = Carbon::today();

        $greeting = ['Selamat Pagi', 'Halo', "Assalamu'alaikum"];

        $borrows_data = [];

        foreach ([3, 2, 1] as $days) {
            $targetDate = $today->copy()->addDays($days);

            $borrows = Borrow::with('user', 'book')
                ->where('status', 'confirmed')
                ->whereDate('due_date', $targetDate)
                ->get();

            foreach ($borrows as $borrow) {
                $message = "> Layanan Chatbot Perpustakaan Umum Kota Solok\n> 🔔 Pengingat Peminjaman Otomatis\n\n{$greeting[$days]} {$borrow->user->name}, peminjaman anda untuk {$borrow->book->physical_shape} {$borrow->book->clean_title} akan jatuh tempo pada {$days} hari lagi. Perhatikan tanggal jatuh tempo dan segera melakukan pengembalian. Terima kasih";
                $wa->sendMessage(formattedPhoneNumberToUs62($borrow->user->phone_number), $message);
                $this->info("Reminder dikirim ke {$borrow->user->phone_number} ({$days} hari lagi)");

                $borrows_data[$days] = $borrow;
            }
        }

        foreach ($borrows_data as $data) {
            $this->info("Berhasil mengirimkan pengingat untuk data peminjaman:\nBuku {$data->book->id}");
        }
    }
}
