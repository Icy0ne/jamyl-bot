<?php

namespace JamylBot\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use JamylBot\Corp;
use JamylBot\Userbot\ApiMonkey;

class GetCorporations extends Command {
	
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'api:getcorporations';
	
	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Pull corporations, update and add new to DB';
	
	/**
	 * Create a new command instance.
	 */
	public function __construct(ApiMonkey $api) {
		$this->api=$api;
		parent::__construct ();
	}
	
	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire() {
		$updatecorps=Corp::listNeedUpdateIds(20);
		foreach ( $updatecorps as $updatecorp ) {
			$newcorpinfo=$this->api->getCorporationInfo($updatecorp);
			$newcorpinfo2=$newcorpinfo->toArray();
			$newcorpinfo2["result"]["cachedUntil"]=$newcorpinfo->toArray()["cachedUntil"];
			$corp=Corp::find($updatecorp);
			$corp->updateCorporations($newcorpinfo2["result"]);
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
