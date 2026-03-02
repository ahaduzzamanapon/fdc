<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        $array = array(
            'status' => 'expired',
            'pay_status' => null,
            'exprired_at' => null
        );
        $time = date('Y-m-d H:i:s', strtotime('-72 hours'));
        \App\Models\Booking::where('pay_status', 'pending')->where('exprired_at', '!=', null)
            ->where('exprired_at', '<=', $time)->update(['status' => 'expired']);

        \Log::info('Auto expired booking checked');
    }
}
