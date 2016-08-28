@extends('layouts.app')

@section('content')

    @if(!$verified)
        <div class="row">
            <div class="col-lg-6">
                <h3>Profile settings</h3>
            </div>

        </div>
        <div class="row">
            <hr>
            <div class="col-lg-5">
                @if(Session::has('message'))
                    <p class="=alert {{ Session::get('alert_class', 'alert-success') }}">{{Session::get('message')}}</p>
                @endif
                {!! Form::open(['method'=>'post','action'=>'ProfileController@resentConf' ]) !!}
                {!! Form::submit('Resent confirmation email', ['class'=>'btn btn-default']) !!}
                {!! Form::close() !!}

            </div>
        </div>
    @else
        <div class="row">
            <div class="col-lg-6">
                <h3>Profile settings</h3>
            </div>
            <div class="col-lg-6">
                {!! Form::open(['method'=>'delete', 'route'=>['profile.destroy', Auth::id()]]) !!}
                {!! Form::submit('Delete Profile', ['class'=>'btn btn-danger']) !!}
                {!! Form::close() !!}
            </div>
        </div>
        <div class="row">
<hr>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Profile</div>
                            <div class="panel-body">
                                {{$user->first_name}}
                            </div>
                        </div>
                    </div>

                </div>
                @if(Session::has('message'))
                    <p class="=alert {{ Session::get('alert_class', 'alert-danger') }}">{{Session::get('message')}}</p>
                @endif
            </div>
    @endif
@endsection