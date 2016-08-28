@extends('layouts.app')
@section('content')

    <div class="row">
        @foreach($events as $event)
            <div class="col-sm-6 col-md-4">
                <a class="thumbnail" href="{{url('event/'.$event->slug)}}"  style="background-color: #46b8da" >
                    <img src="{{url('img/'.$event->id.'.png')}}" alt="{{$event->name}}"
                         >

                <div class="caption">
                    <p>{{$event->name}}</p>

                    <p>{{date("d-m", strtotime($event->start_date))}}
                        - {{date("d-m", strtotime($event->end_date))}} </p>
                </div>
                </a>
            </div>
        @endforeach
    </div>
@stop
