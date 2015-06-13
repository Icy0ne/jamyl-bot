@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">TeamSpeak</div>
                    <div class="panel-body">
				        @if (isset($error))
				        	<div class="alert alert-danger col-md-12" role="alert">{{ $error }}</div>
				        @endif
						<div class="row">
		                    <div class="col-sm-3 text-right">
		                    	<strong>TeamSpeak Address</strong>
		                    </div>
		                    <div class="col-sm-4">
		                    	<a href="ts3server://{{ config('ts3.hostname') }}?port={{ config('ts3.serverport') }}&nickname={{ $user }}">{{ config('ts3.hostname') }}</a>
	                    	</div>
		                    <div class="col-sm-5">
		                    	<a class="btn btn-success btn-sm col-sm-4" href="ts3server://{{ config('ts3.hostname') }}?port={{ config('ts3.serverport') }}&nickname={{ $user }}">Click To Join</a>
	                    	</div>
						</div>
						<div class="row">
		                    <div class="col-sm-3 text-right">
		                    	<strong>Nickname to Use</strong>
		                    </div>
		                    <div class="col-sm-7">{{ $user }}</div>
						</div>
						<div class="row">
		                    <div class="col-sm-3 text-right">
		                    	<strong>TeamSpeak UID</strong>
		                    </div>
		                    <div class="col-sm-4">{{ $tsuid }} </div>
		                    <div class="col-sm-5">
								@if ($tsuid!="")
			                 		{!! Form::open(['action' => ['TeamSpeakController@register'], 'method' => 'post']) !!}
				                    {!! Form::submit('Refresh TS UID', Array('class'=>'btn btn-warning btn-sm col-sm-4')) !!}
			                        {!! Form::close() !!}
		                        @endif
		                    </div>
                    	</div>	
						<div class="row">
		                    <div class="col-sm-offset-3 col-sm-6">
								@if ($tsuid=="")
		    	                    {!! Form::open(['action' => ['TeamSpeakController@register'], 'method' => 'post']) !!}
		                            {!! Form::submit('Register', Array('class'=>'btn btn-success btn-sm col-sm-4')) !!}
			                        {!! Form::close() !!}
		                        @endif
								@if ($tsuid!="")
				                    {!! Form::open(['action' => ['TeamSpeakController@updateAccess'], 'method' => 'post']) !!}
		                            {!! Form::submit('Force Access Update', Array('class'=>'btn btn-danger btn-sm col-sm-6')) !!}
			                        {!! Form::close() !!}
		                        @endif
	                        </div>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection