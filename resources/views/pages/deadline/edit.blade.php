@extends('layouts.app')

@section('content')

    <div class="row">
        <hr>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit deadlines</div>
                <div class="panel-body">
                    <div class="form-inline">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Per Stage(Min-Max)</th>
                                    <th>All Stages(Min-Max)</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($deadline_list as $deadline)
                                    <tr>
                                        <td>
                                            {{$deadline->deadline}}
                                        </td>
                                        <td>
                                            {{$deadline->value1}} &euro;
                                        </td>
                                        <td>
                                            {{$deadline->value2}} &euro;
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <hr>
                    {!! Form::open(['method'=>'PATCH', 'route'=>['event.deadline.update', $event_id, 0], 'class'=>'form-horizontal']) !!}
                    {!! Form::hidden('event_id', $event_id) !!}
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Deadline</th>
                                <th>Per stage(min)</th>
                                <th>Per stage(max)</th>
                                <th>All stages(min)</th>
                                <th>All stages(max)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @for($i=0; $deadline_num>$i; $i++)
                                <tr>
                                    @include('pages.deadline.part')
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-user"></i>Edit Deadlines
                            </button>
                        </div>
                    </div>
                    {!! Form::close()!!}
                    @if(Session::has('message'))
                        <p class="=alert {{ Session::get('alert_class', 'alert-info') }}">{{Session::get('message')}}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <hr>
    <a href="{{url('/event/'.$event_id.'/edit')}}" class="btn btn-default">Back</a>

@stop