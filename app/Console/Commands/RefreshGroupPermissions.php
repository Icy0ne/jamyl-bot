<?php

namespace JamylBot\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use JamylBot\User;
use JamylBot\Group;

class RefreshGroupPermissions extends Command {
	
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'auth:refreshgrouppermissions';
	
	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Syncs group permissions to corp membership';
	
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
    	$group=new Group;
    	$group->updateGroupAccess();
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
