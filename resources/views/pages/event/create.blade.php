@extends('layouts.app')
@section('content')
    <div class="row">
        <hr>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create event</div>
                <div class="panel-body">
                        {!! Form::open(['method'=>'POST', 'route'=>'event.store', 'class'=>'form-horizontal', 'files'=>'true']) !!}

                       @include('pages.event.part')

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Create Event
                                </button>
                            </div>
                        </div>

                        {!! Form::close()!!}
                </div>
            </div>
        </div>
    </div>
    <hr>
    <a href="{{url('/admin')}}" class="btn btn-default">Back</a>
@stop