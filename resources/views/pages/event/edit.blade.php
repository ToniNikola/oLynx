@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3>
                {{$event->name}}
            </h3>
        </div>
    </div>
    <div class="row">
        <hr>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4>Edit event</h4>
                        </div>
                        <div class="col-lg-6">
                            <div style="float:right;">
                                {!! Form::open(['method'=>'delete','route'=>['event.destroy',$event->id], 'class'=>'form-inline']) !!}{!! Form::submit('Destroy', ['class'=>'btn btn-danger']) !!}{!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">

                    {!! Form::model($event,['method'=>'PUT','route'=>['event.update', $event->id], 'class'=>'form-horizontal', 'files'=>'true']) !!}

                    @include('pages.event.part')

                    <div class="form-group{{ $errors->has('si_rent') ? ' has-error' : '' }}">
                        <label class="col-md-4 control-label">Open/Close Registration</label>

                        <div class="col-md-6">
                            {!! Form::radio('open', '1') !!} Open
                            {!! Form::radio('open', '0') !!} Close


                            @if ($errors->has('si_rent'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('si_rent') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-7 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-user"></i>Edit Event
                            </button>

                            @if($deadline_set)
                            <a href="{{url('/event/'.$event->id.'/deadline/'.$deadline_id.'/edit')}}" class="btn btn-success"> <i class="fa fa-btn fa-wrench"></i>Edit Deadlines</a>
                            @else
                            <a href="{{url('/event/'.$event->id.'/deadline/create')}}" class="btn btn-primary"> <i class="fa fa-btn fa-plus"></i>Add Deadlines</a>
                            @endif



                        </div>
                    </div>
                    @if(Session::has('message'))
                        <p class="=alert {{ Session::get('alert_class', 'alert-success') }}">{{Session::get('message')}}</p>
                    @endif
                    {!! Form::close()!!}

                </div>
            </div>
        </div>
    </div>
        <hr>
        <a href="{{url('/admin')}}" class="btn btn-default">Back</a>
@stop