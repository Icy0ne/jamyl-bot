<?php namespace JamylBot\Http\Controllers;

use JamylBot\Channel;
use JamylBot\Group;
use JamylBot\Http\Requests;
use JamylBot\Http\Controllers\Controller;
use JamylBot\User;
use JamylBot\Userbot\Userbot;
use TeamSpeak3;
use JamylBot\TeamSpeakGroup;
use JamylBot\Corp;
use JamylBot\Userbot\ApiMonkey;
use JamylBot\Userbot\TS3Monkey;

class TeamSpeakController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @param Userbot $userbot
	 */
	public function __construct(Userbot $userbot, ApiMonkey $api, TS3Monkey $ts3Monkey, Corp $corp)
	{
		$this->middleware('auth');
		$this->userbot = $userbot;
		$this->user = \Auth::user();
		$this->api=$api;
		$this->ts3Monkey=$ts3Monkey;
		$this->corp=$corp;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('teamspeak.index', ["user"=>$this->user->getTSName(), "tsuid"=>$this->user->tsuid]);
	}

    public function register()
    {
    	if ($this->ts3Monkey->register($this->user)) {
        	return redirect('/teamspeak');
    	} else {
    		return view('teamspeak.index', ["user"=>$this->user->getTSName(), "tsuid"=>$this->user->tsuid, "error"=>"User not found on TeamSpeak server. Please check and use your nickname shown below."]);
    	}
    	
    }
    public function updateAccess()
    {
    	 
    	if ($this->ts3Monkey->updateAccess($this->user)) {
    		return redirect('/teamspeak');
    	} else {
    		return view('teamspeak.index', ["user"=>$this->user->getTSName(), "tsuid"=>$this->user->tsuid, "error"=>"User not found on TeamSpeak server. Please check and use your username shown below."]);
    	}
    	 
    }
    
}
