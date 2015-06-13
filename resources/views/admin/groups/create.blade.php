@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Create new group</div>
                    <div class="panel-body">
                        {!! Form::open(['route' => 'admin.groups.store']) !!}
                        <div class="col-sm-4">{!! Form::text('name', null, Array('placeholder'=>'Enter group name', 'class'=>'form-control')) !!}</div>
                        {!! Form::submit('Create group', Array('class'=>'btn btn-success col-sm-2')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
