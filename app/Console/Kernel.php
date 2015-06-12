<?php namespace JamylBot\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		'JamylBot\Console\Commands\Inspire',
        'JamylBot\Console\Commands\CheckApis',
        'JamylBot\Console\Commands\RegisterSlackUsers',
        'JamylBot\Console\Commands\RunKillbot',
        'JamylBot\Console\Commands\SetSlackInactives',
        'JamylBot\Console\Commands\RunAllChecks',
        'JamylBot\Console\Commands\ReadStandings',
        'JamylBot\Console\Commands\GetSlackChannels',
        'JamylBot\Console\Commands\ManageChannels',
        'JamylBot\Console\Commands\ManuallyAddUser',
        'JamylBot\Console\Commands\TrollPunkslap',
        'JamylBot\Console\Commands\GetCorporations',
        'JamylBot\Console\Commands\GetAlliances',
        'JamylBot\Console\Commands\GetContactLists',
	    'JamylBot\Console\Commands\RefreshGroupPermissions',
	    'JamylBot\Console\Commands\GetTeamSpeakGroups',
	    'JamylBot\Console\Commands\UpdateTeamSpeakAccess',
        'JamylBot\Console\Commands\CheckTeamSpeakNickames',
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		//$schedule->command('inspire')->hourly();
        $schedule->command('jamyl:allchecks')->everyFiveMinutes();
        $schedule->command('jamyl:firekillbot')->everyFiveMinutes();
        $schedule->command('jamyl:manage')->everyFiveMinutes();
        $schedule->command('jamyl:getchannels')->Hourly();
        $schedule->command('jamyl:punk')->dailyAt('10:05');
        $schedule->command('api:getalliances')->dailyAt('00:01');
        $schedule->command('api:getcontactlists')->twiceDaily();
        $schedule->command('api:getcorporations')->everyFiveMinutes();
        $schedule->command('auth:refreshgrouppermissions')->everyFiveMinutes();
        $schedule->command('ts3:checknickames')->everyFiveMinutes();
        $schedule->command('ts3:updateaccess')->everyFiveMinutes();
        //$schedule->command('ts3:getgroups')->twiceDaily();
	}

}
