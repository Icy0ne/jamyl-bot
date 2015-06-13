@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Info for {{ $name }}</div>
                    <div class="panel-body">
                        <div class="col-sm-8">
                            <table class="table table-condensed table-bordered">
                                <tr>
                                    <td class="col-sm-3">ID</td>
                                    <td class="col-sm-9">{{ $id }}</td>
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
                                                <div class="col-sm-7">{{ $channel->name }}</div>
                                                {!! Form::hidden('channel', $channel->id) !!}
                                                <div class="col-sm-5">{!! Form::submit('Remove', Array('class'=>'btn btn-xs btn-danger col-sm-6')) !!}</div>
                                                {!! Form::close() !!}
                                            </div>
                                        @endforeach
                                        <div>
                                            {!! Form::open(['url' => 'admin/groups/'.$id.'/add-channel']) !!}
                                             <div class="col-sm-7">{!! Form::select('channel', $menuChannels, null, array('class' => 'form-control input-sm')) !!}</div>
                                             <div class="col-sm-5">{!! Form::submit('Add', Array('class'=>'btn btn-sm btn-success col-sm-6')) !!}</div>
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
                                                <div class="col-sm-7">{{ $tsgroup->name }}</div>
                                                {!! Form::hidden('tsgroup', $tsgroup->id) !!}
                                                <div class="col-sm-5">{!! Form::submit('Remove', Array('class'=>'btn btn-xs btn-danger col-sm-6')) !!}</div>
                                                {!! Form::close() !!}
                                            </div>
                                        @endforeach
                                        <div>
                                            {!! Form::open(['url' => 'admin/groups/'.$id.'/add-tsgroup']) !!}
                                            <div class="col-sm-7">{!! Form::select('tsgroup', $menuTSGroups, null, array('class' => 'form-control input-sm')) !!}</div>
                                            <div class="col-sm-5">{!! Form::submit('Add', Array('class'=>'btn btn-sm btn-success col-sm-6')) !!}</div>
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                <td>Corp ID</td>
                                	<td>
                                		<div>
											{!! Form::open(['url' => 'admin/groups/'.$id.'/save-corpid', 'class' => 'add-corporation-form']) !!}
					                        <div class="col-sm-8">{!! Form::select('corp_id', array(''=>'None')+$menuCorporations, $corp_id, array('class' => 'form-control input-sm')) !!}</div>
					                        <div class="col-sm-4">{!! Form::submit('Save', Array('class'=>'btn btn-sm btn-success col-sm-6')) !!}</div>
					                        {!! Form::close() !!}
				                        </div>
                        	        </td>
                                </tr>
                                <tr>
                                <td>Alliance ID</td>
                                	<td>
                                		<div>
											{!! Form::open(['url' => 'admin/groups/'.$id.'/save-allianceid', 'class' => 'add-alliance-form']) !!}
					                        <div class="col-sm-8">{!! Form::select('alliance_id', array(''=>'None')+$menuAlliances, $alliance_id, array('class' => 'form-control input-sm')) !!}</div>
                                            <div class="col-sm-4">{!! Form::submit('Save', Array('class'=>'btn btn-sm btn-success col-sm-6')) !!}</div>
					                        {!! Form::close() !!}
				                        </div>
                        	        </td>

                                </tr>
                            </table>
                        </div>
                        <p>&nbsp;</p>
                        <div class="col-sm-5">
                            <h4 class="col-sm-12">Group Owners</h4>
                            @if ($admin)
                                <div class="row">
                                    {!! Form::open(['url' => 'admin/groups/'.$id.'/add-owner', 'class' => 'add-owner-form']) !!}
                                    <div class="col-sm-9">{!! Form::select('owner', array(''=>'Select user')+$menuOwners, null, array('class' => 'form-control input-sm')) !!}</div>
                                    <div class="col-sm-3">{!! Form::submit('Add', Array('class'=>'btn btn-sm btn-success col-sm-12')) !!}</div>
                                    {!! Form::close() !!}
                                </div>
                            @endif
							@if (count($owners))
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
                                                {!! Form::submit('Remove Owner', Array('class'=>'btn btn-xs btn-danger')) !!}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
	                        @else
                                <div class="col-sm-12"><p>This group has no members.</p></div>
                            @endif
                        </div>
                        <div class="col-sm-7">
                            <h4 class="col-sm-6">Members</h4>
                            <div class="row">
                                {!! Form::open(['url' => 'admin/groups/'.$id.'/add-user', 'class' => 'add-user-form']) !!}
                                <div class="col-sm-9">{!! Form::select('user', array(''=>'Select user')+$menuUsers, null, array('class' => 'form-control input-sm')) !!}</div>
                                <div class="col-sm-3">{!! Form::submit('Add', Array('class'=>'btn btn-sm btn-success col-sm-12')) !!}</div>
                                {!! Form::close() !!}
                            </div>
                            @if (count($users))
                                <table class="table table-striped table-condensed">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Char Name</th>
                                        <th>Email</th>
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
                                                {!! Form::submit('Remove User', Array('class'=>'btn btn-xs btn-danger')) !!}
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
    </div>
@endsection
