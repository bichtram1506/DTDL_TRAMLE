<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\BookTour;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $booktours = BookTour::where('b_status', 2)->where('updated_at', '<=', now()->subDays(2))->get();
    
            foreach ($booktours as $booktour) {
                $booktour->b_status = 5;
                $booktour->save();
            }
        })->dailyAt('19:51');
    }

    /**
     * Get the timezone for the schedule.
     *
     * @return string
     */
    protected function scheduleTimezone()
    {
        return 'Asia/Ho_Chi_Minh'; // Thay đổi thành múi giờ của bạn
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        $this->load(__DIR__.'/../Models'); // Thêm đường dẫn tới thư mục Models

        require base_path('routes/console.php');
    }
}