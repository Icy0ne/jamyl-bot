<?php

namespace JamylBot;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {

	protected $fillable = ['name','owners','corp_id','alliance_id'];

	public function users()
	{
		return $this->belongsToMany('JamylBot\User');
	}

	public function channels()
	{
		return $this->belongsToMany('JamylBot\Channel');
	}

	public function getOwners()
	{
		return explode(',', $this->owners);
	}

	public function getMembers()
	{
		$members = $this->users;
		$users = [];
		
		foreach ($members as $user) {
			$users[] = $user->id;
		}
		
		return $users;
	}

	public function setOwners($ownersArray)
	{
		$this->owners = implode(',', $ownersArray);
		$this->save();
	}

	/**
	 *
	 * @param int $newOwner        	
	 */
	public function addOwner($newOwner)
	{
		$owners = $this->getOwners();
		$owners[] = $newOwner;
		$this->owners = implode(',', array_unique($owners));
		$this->save();
	}

	public function removeOwner($owner)
	{
		$owners = $this->getOwners();
		$owners = array_diff($owners, [$owner]);
		$this->setOwners($owners);
	}

	public function isOwner($owner)
	{
		return in_array($owner, $this->getOwners());
	}

	public function isMember($member)
	{
		return in_array($member, $this->getMembers());
	}

	public function isMemberBySlack($slack_id)
	{
		foreach ($this->users as $user) {
			/**
			 *
			 * @var User $user
			 */
			if ($user->slack_id != null && $user->slack_id == $slack_id && $user->hasAccess()) {
				return true;
			}
		}
		return false;
	}

	public function setCorpID($corpID)
	{
		$this->corp_id = $corpID;
		$this->save();
	}

	public function setAllianceID($allianceID)
	{
		$this->alliance_id = $allianceID;
		$this->save();
	}

	public function updateGroupAccess()
	{
		$groups = Group::whereNotNull("corp_id")->get();
		foreach ($groups as $group) {
			$currentusers = $group->users()->get();
			foreach ($currentusers as $currentuser) {
				if ($group->corp_id != $currentuser->corp_id) {
					$group->users()->detach($currentuser);
				}
			}
			$newusers = User::where("corp_id", "=", $group->corp_id)->get();
			foreach ($newusers as $newuser) {
				if (! $group->isMember($newuser->id)) {
					$group->users()->attach($newuser);
				}
			}
		}
		$groups = Group::whereNotNull("alliance_id")->get();
		foreach ($groups as $group) {
			$currentusers = $group->users()->get();
			foreach ($currentusers as $currentuser) {
				if ($group->alliance_id != $currentuser->alliance_id) {
					$group->users()->detach($currentuser);
				}
			}
			$newusers = User::where("alliance_id", "=", $group->alliance_id)->get();
			foreach ($newusers as $newuser) {
				if (! $group->isMember($newuser->id)) {
					$group->users()->attach($newuser);
				}
			}
		}
	}
}
