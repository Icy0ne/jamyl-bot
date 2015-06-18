<?php

namespace JamylBot\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use JamylBot\Userbot\TS3Monkey;
use JamylBot\User;

class CheckTeamSpeakNickames extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'ts3:checknicknames';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks nicknames match';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $teamspeak = new TS3Monkey();
        $currentusers = $teamspeak->clientList();
        foreach ($currentusers as $currentuser) {
            $users = User::where("tsdbid", "=", $currentuser["client_database_id"])->get();
            foreach ($users as $user) {
                if ($user->getTSName() != $currentuser["client_nickname"]) {
                    $user->incorrect_nickname_count = $user->incorrect_nickname_count + 1;
                    $teamspeak->clientPoke($currentuser["client_database_id"], 
                        "Wrong Nickname - Expecting " . $user->getTSName() . " - Warning " .
                             $user->incorrect_nickname_count . "/5");
                    if ($user->incorrect_nickname_count >= 5) {
                        $teamspeak->clientKick($user->tsdbid, "Incorrect Nickname");
                        $user->incorrect_nickname_count = 0;
                    }
                } else {
                    $user->incorrect_nickname_count = 0;
                }
                $user->save();
            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [];
        // ['example', InputArgument::REQUIRED, 'An example argument.'],
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
        // ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
    }
}
