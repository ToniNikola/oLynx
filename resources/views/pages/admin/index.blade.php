@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <h4>Admin Dashboard</h4>
        </div>
        <div class="col-lg-6"></div>
    </div>
    <div class="row">
        <hr>
        <div class="col-lg-3 col-md-4"><a href="#">Event</a></div>
        <div class="col-lg-3 col-md-4">Test2</div>
        <div class="col-lg-3 col-md-4">Test3</div>
        <div class="col-lg-3 col-md-4">Test4</div>
    </div>
    <div class="row">
        <hr>
        <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Events Administration</div>
                <div class="panel-body">
                    <ul class="list-group">
                        @if(count($events) == 0)
                            <li class="list-group-item list-group-item-info">Currently no events.</li>
                        @else
                            @foreach($events as $event)
                                <li class="list-group-item">{{$event->name}} - @if($event->open)[OPEN] @else [CLOSE] @endif - <a href="event/{{$event->id}}/edit">Edit</a>
                                    <span style="float: right"><a href="{{url('/event/'.$event->id.'/registration/admin')}}">Admin</a></span>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div class="panel-footer">
                    <a href="/event/create" class="btn btn-default">
                       <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Create Event
                    </a>
                </div>
            </div>


        </div>
        <div class="col-lg-6"></div>
    </div>
@stop