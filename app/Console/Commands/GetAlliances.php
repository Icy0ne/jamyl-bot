<?php

namespace JamylBot\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use JamylBot\Userbot\ApiMonkey;
use JamylBot\Alliance;
use JamylBot\Corp;
use JamylBot\Contact;

class GetAlliances extends Command {
	
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'api:getalliances';
	
	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Pull alliances, update and add new to DB';
	
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
		
		//Alliances::truncate();
		$alliances=$this->api->getAllianceList()->alliances;
		foreach ($alliances as $alliance) {
			$isblue=Contact::where("id", "=", $alliance["allianceID"])->where("type_id", "=", "16159")->where("standing", ">", 0)->count();
			if ($isblue==1 || $alliance['allianceID']==151380924) {
				$newalliance=new Alliance;
				$newalliance->id=$alliance['allianceID'];
	            $newalliance->name = $alliance['name'];
	            $newalliance->ticker = $alliance['shortName'];
	            $newalliance->executor_corp_id = $alliance['executorCorpID'];
	            $newalliance->members = $alliance['memberCount'];
	            $newalliance->start_date = $alliance['startDate'];
	            $newalliance->save();
				foreach ($alliance->memberCorporations as $corporation) {
		            Corp::firstOrCreate([
		                'id' => $corporation['corporationID'],
		                'alliance_id' => $alliance['allianceID']
		            ]);
				}
				
			}
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
