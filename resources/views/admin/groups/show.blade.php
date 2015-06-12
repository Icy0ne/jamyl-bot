@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Info for {{ $name }}</div>
                    <div class="panel-body">
                        <div class="col-sm-6">
                            <table class="table table-condensed table-bordered">
                                <tr>
                                    <td class="col-sm-4">id</td>
                                    <td class="col-sm-8">{{ $id }}</td>
                                </tr>
                                <tr>
                                    <td>Name</td>
                                    <td>{{ $name }}</td>
                                </tr>
                                <tr>
                                    <td>Linked Channels</td>
                                    <td>
                                        @foreach ($channels as $channel)
                                            <div>
                                                {!! Form::open(['url' => 'admin/groups/'.$id.'/remove-channel']) !!}
                                                {{ $channel->name }}
                                                {!! Form::hidden('channel', $channel->id) !!}
                                                {!! Form::submit('Remove') !!}
                                                {!! Form::close() !!}
                                            </div>
                                        @endforeach
                                        <div>
                                            {!! Form::open(['url' => 'admin/groups/'.$id.'/add-channel']) !!}
                                            {!! Form::select('channel', $menuChannels) !!}
                                            {!! Form::submit('Add channel') !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Linked TS Groups</td>
                                    <td>
                                        @foreach ($tsgroups as $tsgroup)
                                            <div>
                                                {!! Form::open(['url' => 'admin/groups/'.$id.'/remove-tsgroup']) !!}
                                                {{ $tsgroup->name }}
                                                {!! Form::hidden('tsgroup', $tsgroup->id) !!}
                                                {!! Form::submit('Remove') !!}
                                                {!! Form::close() !!}
                                            </div>
                                        @endforeach
                                        <div>
                                            {!! Form::open(['url' => 'admin/groups/'.$id.'/add-tsgroup']) !!}
                                            {!! Form::select('tsgroup', $menuTSGroups) !!}
                                            {!! Form::submit('Add group') !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                <td>Corp ID</td>
                                	<td>
                                		<div>
											{!! Form::open(['url' => 'admin/groups/'.$id.'/save-corpid']) !!}
					                        {!! Form::text('corp_id', $corp_id) !!}
					                        {!! Form::submit('Save') !!}
					                        {!! Form::close() !!}
				                        </div>
                        	        </td>
                                </tr>
                                <tr>
                                <td>Alliance ID</td>
                                	<td>
                                		<div>
											{!! Form::open(['url' => 'admin/groups/'.$id.'/save-allianceid']) !!}
					                        {!! Form::text('alliance_id', $alliance_id) !!}
					                        {!! Form::submit('Save') !!}
					                        {!! Form::close() !!}
				                        </div>
                        	        </td>

                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-6">
                            {!! Form::open(['url' => 'admin/groups/'.$id.'/add-user', 'class' => 'add-user-form']) !!}
                            {!! Form::select('user', array(''=>'Select user')+$menuUsers, null, array('class' => 'form-control')) !!}
                            {!! Form::submit('Add user') !!}
                            {!! Form::close() !!}
                        </div>
                        <p>&nbsp;</p>
                        @if ($admin)
                        <h5><a href="#" id="addOwner">Add Owner:</a></h5>
                        <div class="col-sm-6" style="display: none" id="add-owner-form-div">
                            {!! Form::open(['url' => 'admin/groups/'.$id.'/add-owner', 'class' => 'add-owner-form']) !!}
                            {!! Form::select('owner', array(''=>'Select user')+$menuOwners, null, array('class' => 'form-control')) !!}
                            {!! Form::submit('Add owner') !!}
                            {!! Form::close() !!}
                        </div>
                        @endif
                        @if ($admin && count($owners))
                            <h4 class="col-sm-8">Group Owners</h4>
                            <table class="table table-striped table-condensed">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Char Name</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>
                                @foreach ($owners as $owner)
                                    <tr>
                                        <td class="user-id">{{ $owner->id }}</td>
                                        <td class="char-name">{{ $owner->char_name }}</td>
                                        <td>
                                            {!! Form::open(['url' => 'admin/groups/'.$id.'/remove-owner', 'class' => 'owner-action-form']) !!}
                                            {!! Form::hidden('owner', $owner->id) !!}
                                            {!! Form::submit('Remove owner') !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                        <h4 class="col-sm-8">Members</h4>
                        @if (count($users))
                            <table class="table table-striped table-condensed">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Char Name</th>
                                    <th>email</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="user-id">{{ $user->id }}</td>
                                        <td class="char-name">{{ $user->char_name }}</td>
                                        <td class="user-email">{{ $user->email }}</td>
                                        <td>
                                            {!! Form::open(['url' => 'admin/groups/'.$id.'/remove-user', 'class' => 'user-action-form']) !!}
                                            {!! Form::hidden('user', $user->id) !!}
                                            {!! Form::submit('Remove') !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <div class="col-sm-12"><p>This group has no members.</p></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
