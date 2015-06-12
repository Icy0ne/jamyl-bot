@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">TeamSpeak Groups</div>
                    <div class="panel-body">
                        @if (count($ts3groups))
                            <table class="table table-striped table-condensed">
                                <thead>
                                <tr>
                                    <th>Group</th>
                                </tr>
                                </thead>
                            @foreach ($ts3groups as $group)
                                <tr>
                                    <td><a href="teamspeak/{{ $group->id }}">{{ $group->name }}</a></td>
                                </tr>
                            @endforeach
                            </table>
                        @else
                            <p>No groups to display.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
