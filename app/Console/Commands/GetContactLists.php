<?php

namespace JamylBot\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use JamylBot\Userbot\ApiMonkey;
use JamylBot\Contact;

class GetContactLists extends Command {
	
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'api:getcontactlists';
	
	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Pull standings, update and add new to DB';
	
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
		
		Contact::truncate();
		$contacts=$this->api->getContactList()->allianceContactList;
		foreach ($contacts as $contact) {
            Contact::firstOrCreate([
                'id' => $contact['contactID'],
                'name' => $contact['contactName'],
                'standing' => $contact['standing'],
                'type_id' => $contact['contactTypeID']
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
