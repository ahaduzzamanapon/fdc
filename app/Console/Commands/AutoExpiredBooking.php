<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\Producer;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;

class AutoExpiredBooking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $expireTime = now()->subHours(72);
        $bookings = Booking::where('pay_status', 'pending')
            ->whereNotNull('exprired_at')
            ->where('exprired_at', '<=', $expireTime)
            ->get();

        foreach ($bookings as $booking) {
            $booking->update([
                'status' => 'expired',
                'pay_status' => null,
                'exprired_at' => null
            ]);

            $producer = Producer::find($booking->producer_id);

            if ($producer && $producer->email) {
                try {
                    Mail::to($producer->email)->queue(
                        new NotificationMail([
                            'type' => 'service_acceptance',
                            'subject' => 'আপনার আবেদন এর সময় শেষ হয়েছে',
                            'producer_name' => $producer->owners_name,
                            'status' => $booking->status,
                            'service_name' => 'বুকিং অ্যাপ্লিকেশন',
                            'title' => 'আপনার বুকিং এর সময় শেষ হয়েছে',
                        ])
                    );
                } catch (\Throwable $e) {
                    \Log::error('Mail failed', [
                        'booking_id' => $booking->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }
        \Log::info('Auto expired booking cron executed at ' . now());
    }
}
