<?php
/**
 * TeamSpeak 3 management bot API helper
 * User: Matt
 * Date: 01/05/15
 * Time: 09:37
 */

namespace JamylBot\Userbot;


use TeamSpeak3;
use JamylBot\Group;
/**
 * Class TS3Monkey
 * @package JamylBot\Userbot
 */
class TS3Monkey {

    /**
     * @var TeamSpeak
     */
    protected $ts3monkey;

    /**
     * @param TeamSpeak3 $ts3monkey
     */
    function __construct()
    {
    	$this->ts3monkey = TeamSpeak3::factory("serverquery://serveradmin:FgDGwzQB@46.4.63.104:10011/?server_port=9987");
    	//$this->ts3monkey->selfUpdate(["client_nickname"=>"AdminBot".rand(1,1000)]);
    }
    
    function clientUpdate($param, $setting){
    	return $this->ts3monkey->selfUpdate([$param=>$setting]);
    }
    function clientGetByName($name){
    	return $this->ts3monkey->clientGetByName($name);
    }
    function clientGetServerGroupsByDbid($dbid){
    	return $this->ts3monkey->clientGetServerGroupsByDbid($dbid);
    }
    function serverGroupList(){
    	return $this->ts3monkey->serverGroupList();
    }
    function clientList(){
    	return $this->ts3monkey->clientList();
    }
    function addServerGroup($user, $sgid){
    	$client=$this->ts3monkey->clientGetByDbid((int)$user->tsdbid); 
    	return $client->addServerGroup($sgid);
    }
    function remServerGroup($user, $sgid){
    	$client=$this->ts3monkey->clientGetByDbid((int)$user->tsdbid); 
    	return $client->remServerGroup($sgid);
    }
    function clientPoke($tsdbid, $message){
    	return $this->ts3monkey->clientGetByDbid($tsdbid)->poke($message); 
    }
    function updateAccess ($user) {
    	//$group=new Group;
    	//$group->updateGroupAccess();
    	$ts=$this->ts3monkey;
    	$currentTS3Groups = $ts->clientGetServerGroupsByDbid((int)$user->tsdbid);
    	$groups=($user->groups);
    	//$client=$ts->clientGetByDbid((int)$user->tsdbid); 
    	$currentGroups=[];
    	foreach ($currentTS3Groups as $tsgroup) {
    		if ($tsgroup["sgid"]!=8) { // 8=Guest
    			$currentGroups[$tsgroup["sgid"]]=1;
    		}
    	}
    	foreach ($user->groups as $group) {
    		foreach ($group->tsgroups as $tsgroup) {
    			if (empty($currentGroups[$tsgroup->sgid])) {
    				$ts->serverGroupClientAdd($tsgroup->sgid, (int)$user->tsdbid);
    			} else {
    				unset($currentGroups[$tsgroup->sgid]);
    			}
    		}
    	}
    	if ($user->super_admin) {
    		if (empty($currentGroups["6"])) {
    			$ts->serverGroupClientAdd(6, (int)$user->tsdbid);
    		} else {
    			unset($currentGroups["6"]);
    		}
    	}
    	if ($user->admin) {
    		if (empty($currentGroups["22"])) {
    			$ts->serverGroupClientAdd(22, (int)$user->tsdbid);
    		} else {
    			unset($currentGroups["22"]);
    		}
    	}
    	foreach ($currentGroups as $group=>$value) {
    		$ts->serverGroupClientDel($group, (int)$user->tsdbid);
    	}
    	return true;
    }
    function register($user){
    	$teamspeak=$this->ts3monkey;
    	try {
			$ts3_Client = $teamspeak->clientGetByName($user->getTSName());
        } catch  (\TeamSpeak3_Exception $e) {
			return false;
    	}
    	
    	$user->updateTSIDs($ts3_Client["client_unique_identifier"], $ts3_Client["client_database_id"]);
    	 
    	$this->updateAccess($user);
    	 
    	return true; 
    }

}
