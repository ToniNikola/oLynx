@extends('layouts.app')

@section('content')

    <div class="row">
	<div class="col-lg-6">
	    <h4>Edit Import registration</h4>
	</div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">

                {!! Form::open(['method'=>'POST', 'route'=>['event.registration.store', $event->id], 'class'=>'form-inline', 'id'=>'registrationForm']) !!}
                {!! Form::hidden('event_id' , $event->id) !!}

                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Year</th>
                        <th>Gender</th>
                        <th>Club</th>
                        <th>Country</th>
                        <th>Category</th>
                        <th>Deadline</th>
                        <th>Si-chip</th>
                        <th>Payed</th>
                        @for($a=0; $a<$event->stages; $a++)
                            <th>S{{$a+1}}</th>
                        @endfor
                    </tr>
                    </thead>
                    <tbody>
                    @for($b=1; $b<=count($registration_file); $b++)
                        <tr>
                            <td>
                                {!! Form::text('first_name[]', $registration_file[$b][0],['class'=>'form-control']) !!}
                            </td>
                            <td>
                                {!! Form::text('last_name[]', $registration_file[$b][1],['class'=>'form-control']) !!}
                            </td>
                            <td>
                                {!! Form::text('birth_year[]', $registration_file[$b][2],['class'=>'form-control']) !!}
                            </td>
                            <td>
                                {!! Form::text('gender[]', $registration_file[$b][3],['class'=>'form-control']) !!}
                            </td>
                            <td>
                                {!! Form::text('club[]', $registration_file[$b][4],['class'=>'form-control']) !!}
                            </td>
                            <td>
                                {!! Form::text('country[]', $registration_file[$b][5],['class'=>'form-control']) !!}
                            </td>
                            <td>
                                {!! Form::select('category[]',$category_array, $registration_file[$b][6],['class'=>'form-control']) !!}
                            </td>
                            <td>
                                {!! Form::select('deadline[]', [1=>1,2=>2,3=>3,4=>4,5=>5], $registration_file[$b][7],['class'=>'form-control']) !!}
                            </td>
                            <td>
                                {!! Form::text('si_chip[]', $registration_file[$b][8],['class'=>'form-control']) !!}
                            </td>
                            <td>
                                {!! Form::select('payed[]',['1'=>'Yes', '0'=>'No'],null,['class'=>'form-control']) !!}
                            </td>
                            @for($c=0; $c<$event->stages; $c++)
                                <td>
                                    {!! Form::select('stages[]', [2=>'Yes', 0=>'No', 1=>'Early', 2=>'Normal', 3=>'Late'], $registration_file[$b][9+$c],['class'=>'form-control']) !!}
                                </td>
                            @endfor

                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
        @if(Session::has('message'))
            <p class="=alert {{ Session::get('alert_class', 'alert-danger') }}">{{Session::get('message')}}</p>
        @endif
        {!! Form::submit('Import to Registration', ['class' => 'btn btn-success']) !!}
        {!! Form::close() !!}

    </div>

@stop
