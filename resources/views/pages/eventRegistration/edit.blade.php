@extends('layouts.app')
@section('content')
    <div class="row">
        <hr>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Registration</div>
                <div class="panel-body">
                    <a href="{{url('/event/'.$event->slug.'/registration/create ')}}" class="btn btn-success">Register more runners</a>
                    <div style="float: right">
                    {!! Form::open(['method'=>'PATCH', 'route'=>['event.registration.update', $event->id, 0], 'class'=>'delete-button form-inline']) !!}
                    {!! Form::hidden('event_id', $event->id) !!}
                    {!! Form::hidden('id', null) !!}
                    {!! Form::submit('Delete all Runners', ['class'=>'btn btn-danger']) !!}
                    {!! Form::close() !!}

                    {!! Form::open(['method'=>'PATCH', 'route'=>['event.registration.update', $event->id, 0], 'class'=>'form-inline']) !!}
                    {!! Form::hidden('event_id', $event->id) !!}
                    {!! Form::hidden('runner_id', $runner_id) !!}
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Gender</th>
                                <th>B-year</th>
                                <th>Club</th>
                                <th>Country</th>
                                <th>Category</th>
                                <th>Si-Chip</th>
                                @for($a=0; $a<$event->stages; $a++)
                                    <th>S-{{$a+1}}</th>
                                @endfor
                            </tr>
                            </thead>
                            <tbody class="input_fields_wrap">
                            @foreach($registration_list as $runner)
                                <tr>
                                {!! Form::hidden('id[]', $runner->id) !!}
                                    <td>
                                        {!! Form::text('first_name[]', $runner->first_name, ['class'=>'form-control']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('last_name[]',  $runner->last_name,['class'=>'form-control']) !!}
                                    </td>
                                    <td>
                                        {!! Form::select('gender[]',['male'=>'Male', 'female'=>'Female', 'other'=>'Other'],  $runner->gender, ['class'=>'form-control', 'id'=>'select-stretch']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('birth_year[]', $runner->birth_year, ['class'=>'form-control']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('club[]',  $runner->club, ['class'=>'form-control']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('country[]',  $runner->country,['class'=>'form-control']) !!}
                                    </td>
                                    <td class="category">
                                        <select class="form-control" name="category[]" required id="select-stretch"
                                                id="category' + add + '">\
                                            \@foreach($category as $cat)
                                                <option value="{{$cat}}" @if($cat == $runner->category) selected @endif>{{$cat}}</option>\
                                                \@endforeach
                                        </select>
                                    </td>
                                    <td>
                                        {!! Form::text('si_chip[]',  $runner->si_chip, ['class'=>'form-control']) !!}
                                    </td>
                                    @for($b=0; $b<$event->stages; $b++)
                                        <td>
                                            {!! Form::select("stages[]", [0 => 'No', 1 => 'Early', 2 => 'Normal', 3 => 'Late'], $runner->stages[$b], ['class'=>'form-control','id'=>'select-stretch']) !!}
                                        </td>
                                    @endfor
                                    <td>
                                        <a href='#' class='remove_field'>Remove</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    @if(Session::has('message'))
                        <p class="=alert {{ Session::get('alert_class', 'alert-info') }}">{{Session::get('message')}}</p>
                    @endif
                    <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-user"></i>Edit
                            </button>
                    </div>
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </div>
    <hr>
    <a href="{{url('/event/'.$event->id.'/edit')}}" class="btn btn-default">Back</a>
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>

    <script>
        $(document).ready(function () {

            var wrapper = $(".input_fields_wrap"); //Fields wrapper
            var template = $('#hidden-template').html();
            var x = 1; //initlal text box count


            $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
                e.preventDefault();
                $(this).closest('tr').remove();
                x--;
            })
            $(function() {
                $('.delete-button').click(function() {
                    return window.confirm("Are you sure you want to delete all registration? That will remove the deadline too.");
                });
            });
        });
    </script>
@stop