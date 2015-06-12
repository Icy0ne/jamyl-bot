<?php

namespace JamylBot\Http\Controllers;

use JamylBot\Channel;
use JamylBot\Group;
use JamylBot\Http\Requests;
use JamylBot\Http\Controllers\Controller;
use JamylBot\User;


class GroupController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $groups = Group::orderBy("name")->get();
        foreach ($groups as $group) {
            $ownerNames = [];
            $owners = $group->getOwners();
            foreach ($owners as $owner) {
                /**
                 *
                 * @var User $user
                 */
                $user = User::find($owner);
                if ($user != null) {
                    $ownerNames[] = $user->char_name;
                } else {
                    $group->removeOwner($owner);
                }
            }
            $group->owners = implode(', ', $ownerNames);
        }
        return view('admin.groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        Group::create(
            [
                'name' => \Request::input('name'),
                'owners' => \Auth::user()->id
            ]);
        return redirect('/admin/groups');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id            
     * @return Response
     */
    public function show($id)
    {
        /**
         *
         * @var Group $group
         */
        $group = Group::find($id);
        if ($group == null) {
            abort(404);
        }
        $otherUsers = User::all();
        $menuUsers = [];
        foreach ($group->users as $user) {
            $otherUsers = $otherUsers->except($user->id);
        }
        foreach ($otherUsers as $user) {
            $menuUsers[$user->id] = $user->char_name;
        }
        $otherChannels = Channel::all();
        $menuChannels = [];
        foreach ($group->channels as $channel) {
            $otherChannels = $otherChannels->except($channel->id);
        }
        foreach ($otherChannels as $channel) {
            $menuChannels[$channel->id] = $channel->name;
        }
        $notOwners = User::all();
        $menuOwners = [];
        $owners = [];
        foreach ($group->getOwners() as $ownerId) {
            if ($owner = User::find($ownerId)) {
                $owners[] = $owner;
                $notOwners = $notOwners->except($ownerId);
            } else {
                $group->removeOwner($ownerId);
            }
        }
        foreach ($notOwners as $owner) {
            $menuOwners[$owner->id] = $owner->char_name;
        }

        return view('admin.groups.show', 
            [
                'id' => $group->id,
                'name' => $group->name,
                'channels' => $group->channels,
                'users' => $group->users,
                'menuUsers' => $menuUsers,
                'menuChannels' => $menuChannels,
                'admin' => \Auth::user()->admin,
                'owners' => $owners,
                'menuOwners' => $menuOwners,
                'corp_id' => $group->corp_id,
                'alliance_id' => $group->alliance_id
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id            
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id            
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id            
     * @return Response
     */
    public function destroy($id)
    {
        $group = Group::find($id)->first();
        $group->channels()->sync([]);
        $group->users()->sync([]);
        $group->delete();
        return redirect('/admin/groups');
    }

    public function addUserToGroup($groupId)
    {
        $group = Group::find($groupId);
        $group->users()->attach(\Request::input('user'));
        /*
         * Ajax code added in controller, but not in Javascript.
         * Debating whether it is appropriate to use Ajax in this case.
         */
        if (\Request::ajax()) {
            $user = User::find(input('user'));
            return \Response::json(
                array(
                    'status' => 'ok',
                    'user' => array(
                        'id' => $user->id,
                        'charname' => $user->char_name,
                        'email' => $user->email
                    )
                ));
        }
        return redirect('/admin/groups/' . $groupId);
    }

    public function removeUserFromGroup($groupId)
    {
        $group = Group::find($groupId);
        $group->users()->detach(\Request::input('user'));
        if (\Request::ajax()) {
            return \Response::json(
                array(
                    'status' => 'ok'
                ));
        }
        return redirect('/admin/groups/' . $groupId);
    }

    public function addChannelToGroup($groupId)
    {
        $group = Group::find($groupId);
        $group->channels()->attach(\Request::input('channel'));
        return redirect('/admin/groups/' . $groupId);
    }

    public function removeChannelFromGroup($groupId)
    {
        $group = Group::find($groupId);
        $group->channels()->detach(\Request::input('channel'));
        return redirect('/admin/groups/' . $groupId);
    }

    public function addOwnerToGroup($groupId)
    {
        /**
         *
         * @var Group $group
         */
        $group = Group::find($groupId);
        $group->addOwner(\Request::input('owner'));
        return redirect('/admin/groups/' . $groupId);
    }

    public function removeOwnerFromGroup($groupId)
    {
        /**
         *
         * @var Group $group
         */
        $group = Group::find($groupId);
        $group->removeOwner(\Request::input('owner'));
        return redirect('/admin/groups/' . $groupId);
    }

    public function saveCorpID($groupId)
    {
        /**
         *
         * @var Group $group
         */
        $group = Group::find($groupId);
        $group->setCorpID(\Request::input('corp_id'));
        return redirect('/admin/groups/' . $groupId);
    }

    public function saveAllianceID($groupId)
    {
        /**
         *
         * @var Group $group
         */
        $group = Group::find($groupId);
        $group->setAllianceID(\Request::input('alliance_id'));
        return redirect('/admin/groups/' . $groupId);
    }
}