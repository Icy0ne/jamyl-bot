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
 * 
 * @package JamylBot\Userbot
 */
class TS3Monkey {

    /**
     *
     * @var TeamSpeak
     */
    protected $ts3monkey;

    /**
     *
     * @param TeamSpeak3 $ts3monkey            
     */
    function __construct()
    {}

    function connect()
    {
        if (empty($this->ts3monkey)) {
            $this->ts3monkey = TeamSpeak3::factory(
                "serverquery://" . config('ts3.username') . ":" . config('ts3.password') . "@" .
                     config('ts3.hostname') . ":" . config('ts3.serverqueryport') . "/?server_port=" .
                     config('ts3.serverport'));
            $this->ts3monkey->selfUpdate([
                "client_nickname" => env('WEB_GROUP_NAME') . " Admin Bot"
            ]);
            \Log::info("tsmonkey init");
        }
        return $this->ts3monkey;
    }

    function clientUpdate($param, $setting)
    {
        return $this->connect()->selfUpdate([
            $param => $setting
        ]);
    }

    function clientGetByName($name)
    {
        return $this->connect()->clientGetByName($name);
    }

    function clientGetServerGroupsByDbid($dbid)
    {
        return $this->connect()->clientGetServerGroupsByDbid($dbid);
    }

    function serverGroupList()
    {
        return $this->connect()->serverGroupList();
    }

    function clientList()
    {
        return $this->connect()->clientList();
    }

    function addServerGroup($user, $sgid)
    {
        $client = $this->connect()->clientGetByDbid((int) $user->tsdbid);
        return $client->addServerGroup($sgid);
    }

    function remServerGroup($user, $sgid)
    {
        $client = $this->connect()->clientGetByDbid((int) $user->tsdbid);
        return $client->remServerGroup($sgid);
    }

    function clientPoke($tsdbid, $message)
    {
        return $this->connect()
            ->clientGetByDbid($tsdbid)
            ->poke($message);
    }

    function updateAccess($user)
    {
        // $group=new Group;
        // $group->updateGroupAccess();
        $ts = $this->connect();
        $currentTS3Groups = $ts->clientGetServerGroupsByDbid((int) $user->tsdbid);
        $groups = ($user->groups);
        // $client=$ts->clientGetByDbid((int)$user->tsdbid);
        $currentGroups = [];
        foreach ($currentTS3Groups as $tsgroup) {
            if ($tsgroup["sgid"] != 8) { // 8=Guest
                $currentGroups[$tsgroup["sgid"]] = 1;
            }
        }
        foreach ($user->groups as $group) {
            foreach ($group->tsgroups as $tsgroup) {
                if (empty($currentGroups[$tsgroup->sgid])) {
                    $ts->serverGroupClientAdd($tsgroup->sgid, (int) $user->tsdbid);
                } else {
                    unset($currentGroups[$tsgroup->sgid]);
                }
            }
        }
        if ($user->super_admin) {
            if (empty($currentGroups["6"])) {
                $ts->serverGroupClientAdd(6, (int) $user->tsdbid);
            } else {
                unset($currentGroups["6"]);
            }
        }
        if ($user->admin) {
            if (empty($currentGroups["22"])) {
                $ts->serverGroupClientAdd(22, (int) $user->tsdbid);
            } else {
                unset($currentGroups["22"]);
            }
        }
        foreach ($currentGroups as $group => $value) {
            $ts->serverGroupClientDel($group, (int) $user->tsdbid);
        }
        return true;
    }

    function register($user)
    {
        $teamspeak = $this->connect();
        try {
            $ts3_Client = $teamspeak->clientGetByName($user->getTSName());
        } catch (\TeamSpeak3_Exception $e) {
            return false;
        }
        $user->updateTSIDs($ts3_Client["client_unique_identifier"], 
            $ts3_Client["client_database_id"]);
        $this->updateAccess($user);
        return true;
    }
}
