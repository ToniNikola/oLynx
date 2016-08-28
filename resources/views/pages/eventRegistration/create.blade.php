@extends('layouts.app')

@section('content')

    <div class="row">
        <hr>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    {!! Form::open(['method'=>'POST', 'route'=>['event.registration.store', $event->id], 'class'=>'form-inline', 'id'=>'registrationForm']) !!}
                    {!! Form::hidden('event_id', $event->id) !!}
                    <button class="btn btn-success add_field_button">Add More Fields</button>
                    @if($check_if_registered)
                        <a class="btn btn-info" href="{{url('/event/'.$event->slug.'/registration/edit')}}"
                           style="float:right;">Edit Registrations</a>
                    @endif
                    <hr>
                    @if($event->si_rent)
                        <p>This event has enabled Si-Chip rent. That means if you let the Si-Chip field blank you are
                            renting Si-Chip from the organizer.</p>
                    @else
                        <p>This event has disabled SI-Chip rent. That means you need to fill out the Si-Chip field.</p>
                    @endif
                    <hr>
                    {!! Form::label('Club', 'Club:') !!}
                    <input type="text" name="club" class="form-control" required minlength="3" maxlength="30"
                           id="club1">
                    <hr>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Gender</th>
                                <th>B-year</th>
                                <th>Country</th>
                                <th>Category</th>
                                <th>Si-Chip</th>
                                @for($a=0; $a<$event->stages; $a++)
                                    <th>S-{{$a+1}}</th>
                                @endfor
                            </tr>
                            </thead>
                            <tbody class="input_fields_wrap">

                            </tbody>
                        </table>
                    </div>
                    <hr>
                    @if(Session::has('message'))
                        <p class="=alert {{ Session::get('alert_class', 'alert-info') }}">{{Session::get('message')}}</p>
                    @endif
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-user"></i>Register
                            </button>
                        </div>
                    </div>
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </div>
    <hr>
    <a href="{{url('/event/'.$event->slug)}}" class="btn btn-default">Back</a>


    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script>
        $(document).ready(function () {
            var max_fields = 20; //maximum input boxes allowed
            var wrapper = $(".input_fields_wrap"); //Fields wrapper
            var add_button = $(".add_field_button"); //Add button ID
            var template = $('#hidden-template').html();
            var add = 1;

            setTimeout(function () {
                $(add_button).trigger('click');
            }, 1);

            var x = 1; //initlal text box count
            $(add_button).click(function (e) { //on add input button click
                e.preventDefault();
                if (x < max_fields) { //max input box allowed
                    x++; //text box increment
                    add++;
                    $(wrapper).append(' <tr> \
                            <td><input type="text" name="first_name[]" class="form-control" required  minlength="3" maxlength="30" id="first' + add + '"></td>\
                            <td><input type="text" name="last_name[]" class="form-control" required minlength="3" maxlength="30" id="last' + add + '"></td>\
                            <td> <select class="form-control" name="gender[]" required id="gender' + add + '">\
                                <option value="female">Female</option>\
                                <option value="male">Male</option>\
                                <option value="other">Other</option>\
                            </select></td>\
                            <td><input type="text" name="birth_year[]" class="form-control" required minlength="4" maxlength="4" id="year' + add + '"></td>\
                            <td><input type="text" name="country[]" class="form-control" required minlength="3" maxlength="30" id="country' + add + '"></td>\
                            <td><select class="form-control" name="category[]" required id="category' + add + '">\
                            \@foreach($category as $cat)
                                <option value="{{$cat}}">{{$cat}}</option>\
                                \@endforeach
                            </select></td>\
                            <td><input type="text" name="si_chip[]" class="form-control"<?php if(!$event->si_rent){ echo('required');} ?> minlength="3" maxlength="30" id="chip' + add + '"></td>\
                            @for($b=1; $b<=$event->stages; $b++)\
                            <td><select class="form-control" name="stages[]" required id="stages' + add + '"> \
                                <option value="0">No</option>\
                                <option value="1">Early</option>\
                                <option value="2">Normal</option>\
                                <option value="3">Late</option>\
                            </select></td>\
                            @endfor\
                             <td><a href="#" class="remove_field">Remove</a></td>\
                        </tr>'); //add input box

                }
            });


            $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text

                e.preventDefault();

                if (x > 2) {
                    $(this).closest('tr').remove();
                    x--;
                }

            })
        });
    </script>
    <script src="/js/validation/jquery.validate.js"></script>
    <script src="/js/validation/registration-form-validation.js"></script>
@stop
