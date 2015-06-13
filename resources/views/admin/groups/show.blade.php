@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Info for {{ $name }}</div>
                    <div class="panel-body">
                        <div class="col-sm-12">
                            <table class="table table-condensed table-bordered">
                                <tr>
                                    <th class="col-sm-2">ID</th>
                                    <td class="col-sm-10" colspan="3">{{ $id }}</td>
                                </tr>
                                <tr>
                                    <th>Name</th>
                                    <td colspan="3">{{ $name }}</td>
                                </tr>
                                <tr>
                                    <th>Linked Channels</th>
                                    <td>
                                        <table class="table table-striped table-condensed">
	            							@if (count($channels))
		            							<tbody>
                                                    @foreach ($channels as $channel)
                                                        <tr>
                                                            <td class="user-id">{{ $channel->name }}</td>
                                                            <td>
                                                                {!! Form::open(['url' => 'admin/groups/'.$id.'/remove-channel']) !!}
                                                                {!! Form::hidden('channel', $channel->id) !!}
                												{!! Form::submit('Remove', Array('class'=>'btn btn-sm btn-danger col-sm-12')) !!}
                                                                {!! Form::close() !!}
                                                            </td>
                                                        </tr>
                                                    @endforeach
		            							<tbody>
                	                        @else
                                                <div class="col-sm-12"><p>This group has no linked channels.</p></div>
                                            @endif
											{!! Form::open(['url' => 'admin/groups/'.$id.'/add-channel']) !!}
    											<tfoot>
                                                    <tr>
                                                        <td>{!! Form::select('channel', $menuChannels, null, array('class' => 'form-control input-sm')) !!}</td>
                                                        <td>{!! Form::submit('Add', Array('class'=>'btn btn-sm btn-success col-sm-12')) !!}</td>
                                                    </tr>
    											</tfoot>
                                            {!! Form::close() !!}
                                        </table>
                                    </td>
                                	<td class="col-sm-6" rowspan=2>
										<span style="font-weight:bold">Automatic Group Membership</span>
                                		<div class="col-sm-12">If Corporation Is</div>
                                		<div class="col-sm-12">
											{!! Form::open(['url' => 'admin/groups/'.$id.'/save-corpid', 'class' => 'add-corporation-form']) !!}
					                        <div class="col-sm-8">{!! Form::select('corp_id', array(''=>'N/A')+$menuCorporations, $corp_id, array('class' => 'form-control')) !!}</div>
					                        <div class="col-sm-4">{!! Form::submit('Save', Array('class'=>'btn btn-success col-sm-12')) !!}</div>
					                        {!! Form::close() !!}
				                        </div>
                                		<div class="col-sm-12"><h4>OR</h4></div>
                                		<div class="col-sm-12">If Alliance Is</div>
                                		<div class="col-sm-12">
											{!! Form::open(['url' => 'admin/groups/'.$id.'/save-allianceid', 'class' => 'add-alliance-form']) !!}
					                        <div class="col-sm-8">{!! Form::select('alliance_id', array(''=>'N/A')+$menuAlliances, $alliance_id, array('class' => 'form-control')) !!}</div>
                                            <div class="col-sm-4">{!! Form::submit('Save', Array('class'=>'btn btn-success col-sm-12')) !!}</div>
					                        {!! Form::close() !!}
				                        </div>
                        	        </td>
                                </tr>
                                <tr>
                                    <th>Linked TS Groups</th>
                                    <td>
                                        <table class="table table-striped table-condensed">
	            							@if (count($tsgroups))
		            							<tbody>
                                                    @foreach ($tsgroups as $tsgroup)
                                                        <tr>
                                                            <td class="user-id">{{ $tsgroup->name }}</td>
                                                            <td>
                                                                {!! Form::open(['url' => 'admin/groups/'.$id.'/remove-tsgroup']) !!}
                                                                {!! Form::hidden('tsgroup', $tsgroup->id) !!}
                												{!! Form::submit('Remove', Array('class'=>'btn btn-sm btn-danger col-sm-12')) !!}
                                                                {!! Form::close() !!}
                                                            </td>
                                                        </tr>
                                                    @endforeach
		            							<tbody>
                	                        @else
                                                <div class="col-sm-12"><p>This group has no linked TS groups.</p></div>
                                            @endif
											{!! Form::open(['url' => 'admin/groups/'.$id.'/add-channel']) !!}
    											<tfoot>
                                                    <tr>
                                                        <td>{!! Form::select('tsgroup', $menuTSGroups, null, array('class' => 'form-control input-sm')) !!}</td>
                                                        <td>{!! Form::submit('Add', Array('class'=>'btn btn-sm btn-success col-sm-12')) !!}</td>
                                                    </tr>
    											</tfoot>
                                            {!! Form::close() !!}
                                        </table>
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
                                    <div class="col-sm-9">{!! Form::select('owner', array(''=>'Select user')+$menuOwners, null, array('class' => 'form-control')) !!}</div>
                                    <div class="col-sm-3">{!! Form::submit('Add', Array('class'=>'btn btn-success col-sm-12')) !!}</div>
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
                                <div class="col-sm-9">{!! Form::select('user', array(''=>'Select user')+$menuUsers, null, array('class' => 'form-control')) !!}</div>
                                <div class="col-sm-3">{!! Form::submit('Add', Array('class'=>'btn btn-success col-sm-12')) !!}</div>
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
