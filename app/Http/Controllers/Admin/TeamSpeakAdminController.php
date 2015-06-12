<?php namespace JamylBot\Http\Controllers;

use JamylBot\Channel;
use JamylBot\Group;
use JamylBot\Http\Requests;
use JamylBot\Http\Controllers\Controller;
use JamylBot\User;
use TeamSpeak3;
use JamylBot\TeamSpeakGroup;

class TeamSpeakAdminController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		// connect to local server, authenticate and spawn an object for the virtual server on port 9987
		$ts3_VirtualServer = TeamSpeak3::factory ( "serverquery://icyone:sFB0V+LL@46.4.63.104:10011/?server_port=9987" );
		// query clientlist from virtual server and filter by platform
		$arr_ClientList = $ts3_VirtualServer->serverGroupList ();
		// walk through list of clients
		foreach ( $arr_ClientList as $ts3_Client ) {
			TeamSpeakGroup::firstOrCreate([
					'name' => $ts3_Client->name,
					'sgid' => $ts3_Client->sgid
			]);
		}
		
		$ts3groups=TeamSpeakGroup::all();
		return view('admin.teamspeak.index', ["ts3groups"=>$ts3groups]);
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
		Group::create(['name' => \Request::input('name'), 'owners' => \Auth::user()->id]);
        return redirect('/admin/groups');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        /** @var Group $group */
        $group = TeamSpeakGroup::find($id);
        if ($group == null) {
            abort(404);
        }
        

        return view('admin.teamspeak.show', [
            'id'    => $group->id,
            'name'  => $group->name,
            'sgid'  => $group->sgid,
            'admin'     => \Auth::user()->admin,
        ]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
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
            Ajax code added in controller, but not in Javascript.
            Debating whether it is appropriate to use Ajax in this case.
        */
        if (\Request::ajax()) {
            $user = User::find(input('user'));
            return \Response::json(array(
                'status' => 'ok',
                'user'   => array(
                    'id'       => $user->id,
                    'charname' => $user->char_name,
                    'email'    => $user->email
                )
            ));
        }
        return redirect('/admin/groups/'.$groupId);
    }

    public function removeUserFromGroup($groupId)
    {
        $group = Group::find($groupId);
        $group->users()->detach(\Request::input('user'));
        if (\Request::ajax()) {
            return \Response::json(array('status' => 'ok'));
        }
        return redirect('/admin/groups/'.$groupId);
    }

    public function addChannelToGroup($groupId)
    {
        $group = Group::find($groupId);
        $group->channels()->attach(\Request::input('channel'));
        return redirect('/admin/groups/'.$groupId);
    }

    public function removeChannelFromGroup($groupId)
    {
        $group = Group::find($groupId);
        $group->channels()->detach(\Request::input('channel'));
        return redirect('/admin/groups/'.$groupId);
    }

    public function addOwnerToGroup($groupId)
    {
        /** @var Group $group */
        $group = Group::find($groupId);
        $group->addOwner(\Request::input('owner'));
        return redirect('/admin/groups/'.$groupId);
    }

    public function removeOwnerFromGroup($groupId)
    {
        /** @var Group $group */
        $group = Group::find($groupId);
        $group->removeOwner(\Request::input('owner'));
        return redirect('/admin/groups/'.$groupId);
    }

}
