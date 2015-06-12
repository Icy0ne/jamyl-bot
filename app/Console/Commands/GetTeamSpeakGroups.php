<?php

namespace JamylBot\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use JamylBot\TeamSpeakGroup;
use JamylBot\Userbot\TS3Monkey;

class GetTeamSpeakGroups extends Command {
	
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ts3:getgroups';
	
	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Pull group list from TeapSpeak and add new to DB';
	
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
		$groups = $teamspeak->serverGroupList ();
		foreach ( $groups as $group ) {
			TeamSpeakGroup::firstOrCreate([
					'name' => $group['name'],
					'sgid' => $group['sgid']
			]);
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
