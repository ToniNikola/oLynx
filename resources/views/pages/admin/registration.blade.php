@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-lg-6">
            <h4>
                Registration Admin Panel
            </h4>
        </div>
        <div class="col-lg-6"></div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-6">
            Manage registrations:
            {!! Form::open(['method'=>'GET', 'action'=> ['EventRegistrationController@manage', $event->id]]) !!}
            {!! Form::submit('Manage All Registrations', ['class'=>'btn btn-success']) !!}
            {!! Form::close() !!}
            Manage rented:
            {!! Form::open(['method'=>'GET', 'action'=> ['EventRegistrationController@manageRented', $event->id]]) !!}
            {!! Form::submit('Manage Rented SI-Chip', ['class'=>'btn btn-success']) !!}
            {!! Form::close() !!}
        </div>
        <div class="col-lg-6">
        <div>
            <hr>
            <h3>Export Registration</h3>
            <hr>
            {!! Form::open(['method' => 'POST','action' => ['EventRegistrationController@exportRegistration', $event->id]]) !!}
            {!! Form::submit('Download Registration CSV-file', ['class'=>'btn btn-success']) !!}
            {!! Form::close() !!}
            <hr>
            {!! Form::open(['method' => 'POST','action' => ['EventRegistrationController@exportCategory', $event->id]]) !!}
            {!! Form::submit('Download Category CSV-file', ['class'=>'btn btn-success']) !!}
            {!! Form::close() !!}
        </div>

        <div>
            <hr>
            <h3>Import Runners</h3>
            <hr>
            <p>Format rules:<br>
                first_name,last_name,year,gender,club,country,category,deadline,si_chip,payed,s1,s2,s3,s4,s5
            </p>
            {!! Form::open(['method'=>'POST', 'action'=>['EventRegistrationController@importRegistration', $event->id], 'files'=>'true' ]) !!}
            {!! Form::hidden('edition_id', $event->id) !!}
            {!! Form::hidden('competition_slug', $event->slug) !!}
            {!! Form::file('file', ['class'=>'form-group']) !!}
            @if(Session::has('message-file'))
                <p class="=alert {{ Session::get('alert_class', 'alert-danger') }}">{{Session::get('message-file')}}</p>
            @endif
            {!! Form::submit('Import Registration CSV-file', ['class'=>'btn btn-success']) !!}
            {!! Form::close() !!}
        </div>
        </div>
    </div>
    @if(Session::has('message'))
        <p class="=alert {{ Session::get('alert_class', 'alert-danger') }}">{{Session::get('message')}}</p>
    @endif

@stop