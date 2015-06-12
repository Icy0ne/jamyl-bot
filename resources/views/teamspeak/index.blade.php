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
		                    <div class="col-sm-2">
		                    	<strong>Nickname to Use</strong>
		                    </div>
		                    <div class="col-sm-10">{{ $user }}</div>
						</div>
						<div class="row">
		                    <div class="col-sm-2">
		                    	<strong>TeamSpeak UID</strong>
		                    </div>
		                    <div class="col-sm-4">{{ $tsuid }} </div>
		                    <div class="col-sm-6">
								@if ($tsuid!="")
			                 		{!! Form::open(['action' => ['TeamSpeakController@register'], 'method' => 'post']) !!}
				                    {!! Form::submit('Refresh TS UID') !!}
			                        {!! Form::close() !!}
		                        @endif
		                    </div>
                    	</div>	
						<div class="row">
		                    <div class="col-sm-offset-2 col-sm-2">
								@if ($tsuid=="")
		    	                    {!! Form::open(['action' => ['TeamSpeakController@register'], 'method' => 'post']) !!}
		                            {!! Form::submit('Register') !!}
			                        {!! Form::close() !!}
		                        @endif
								@if ($tsuid!="")
				                    {!! Form::open(['action' => ['TeamSpeakController@updateAccess'], 'method' => 'post']) !!}
		                            {!! Form::submit('Update Access') !!}
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