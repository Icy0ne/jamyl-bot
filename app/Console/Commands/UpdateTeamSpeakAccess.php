<?php

namespace JamylBot\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use JamylBot\Userbot\TS3Monkey;
use JamylBot\User;

class UpdateTeamSpeakAccess extends Command {
	
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ts3:updateaccess';
	
	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Updates access for TS';
	
	/**
	 * Create a new command instance.
	 */
	public function __construct() {
		parent::__construct ();
	}
	
	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire() {
		$teamspeak = new TS3Monkey;
		$users=User::where("tsuid", "!=", "")->get();
		foreach ( $users as $user ) {
			$teamspeak->updateAccess($user);
		}
	}
	
	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments() {
		return [ ]
		// ['example', InputArgument::REQUIRED, 'An example argument.'],
		;
	}
	
	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions() {
		return [ ]
		// ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		;
	}
}
