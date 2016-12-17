<?php namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'App\Console\Commands\Inspire',
		'App\Console\Commands\SendNotificationEmails',
		'App\Console\Commands\CommandReadFeeds'
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		 $logPath = base_path() . '/storage/logs/log.log';
		/*$schedule->command('emails:SendNotificationEmails')->everyFiveMinutes()->sendOutputTo($logPath)
    ->emailOutputTo('khaninejad@gmail.com');*/
		$schedule->command('feed:read')->everyThirtyMinutes();
		$schedule->command('emails:SendNotificationEmails')->everyFiveMinutes();
	}

}
