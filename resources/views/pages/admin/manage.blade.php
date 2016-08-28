@extends('layouts.app')
@section('content')
    <div class="row">
        <hr>
        <div class="col-md-12" id="runners">
            <div class="panel panel-default">
                <div class="panel-heading">Admin: Manage Registration<span
                            style="float:right">Total runners: {{count($registration_list)}}</span></div>
                <div class="panel-body">
                    <hr>
                    <input class="search form-group" placeholder="Search"/>
                    {!! Form::open(['method'=>'PATCH', 'route'=>['event.registration.update', $event->id, 0], 'class'=>'form-inline']) !!}
                    {!! Form::hidden('event_id', $event->id) !!}
                    {!! Form::hidden('runner_id', $runner_id) !!}
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th><a class="sort btn" data-sort="number">No.</a></th>
                                <th><a class="sort btn" data-sort="first_name">First Name</a></th>
                                <th><a class="sort btn" data-sort="last_name">Last Name</a></th>
                                <th><a class="sort btn" data-sort="gender">Gender</a></th>
                                <th><a class="sort btn" data-sort="birth_year">B-year</a></th>
                                <th><a class="sort btn" data-sort="club">Club</a></th>
                                <th><a class="sort btn" data-sort="country">Country</a></th>
                                <th><a class="sort btn" data-sort="category">Category</a></th>
                                <th><a class="sort btn" data-sort="si_chip">Si-Chip</a></th>
                                <th><a class="sort btn" data-sort="payed">Payed</a></th>
                                @for($a=0; $a<$event->stages; $a++)
                                    <th><a class="sort btn" data-sort="s-{{$a+1}}">S-{{$a+1}}</a></th>
                                @endfor
                                <th><a class="sort btn" data-sort="deadline">Deadline</a></th>
                            </tr>
                            </thead>
                            <tbody class="list" id="edit-registration">
                            <?php $num = 1; ?>
                            @foreach($registration_list as $runner)
                                <tr>
                                    {!! Form::hidden('id[]', $runner->id) !!}
                                    <td class="number">
                                        {{$num++}}. @if($runner->rented)  R @endif
                                    </td>
                                    <td class="first_name">
                                        {!! Form::text('first_name[]', $runner->first_name, ['class'=>'form-control']) !!}
                                    </td>
                                    <td class="last_name">
                                        {!! Form::text('last_name[]',  $runner->last_name,['class'=>'form-control']) !!}
                                    </td>
                                    <td class="gender">
                                        {!! Form::select('gender[]',['male'=>'Male', 'female'=>'Female', 'other'=>'Other'],  $runner->gender, ['class'=>'form-control']) !!}
                                    </td>
                                    <td class="birth_year">
                                        {!! Form::text('birth_year[]', $runner->birth_year, ['class'=>'form-control']) !!}
                                    </td>
                                    <td class="club">
                                        {!! Form::text('club[]',  $runner->club, ['class'=>'form-control']) !!}
                                    </td>
                                    <td class="country">
                                        {!! Form::text('country[]',  $runner->country,['class'=>'form-control']) !!}
                                    </td>
                                    <td class="category">
                                        <select class="form-control" name="category[]" required
                                                id="category' + add + '">\
                                            \@foreach($category as $cat)
                                                <option value="{{$cat}}" @if($cat == $runner->category) selected @endif>{{$cat}}</option>\
                                                \@endforeach
                                        </select>
                                    </td>
                                    <td class="si_chip">
                                        {!! Form::text('si_chip[]',  $runner->si_chip, ['class'=>'form-control']) !!}
                                    </td>
                                    <td class="payed">
                                        {!! Form::select('payed[]', [0=>'No', 1=>'Yes'], $runner->payed, ['class'=>'form-control']) !!}
                                    </td>
                                    @for($b=0; $b<$event->stages; $b++)
                                        <td class="s-{{$b+1}}">
                                            {!! Form::select("stages[]", [0 => 'No', 1 => 'Early', 2 => 'Normal', 3 => 'Late'], $runner->stages[$b], ['class'=>'form-control']) !!}
                                        </td>
                                    @endfor

                                    <td class="deadline">
                                        {!! Form::select("deadline[]", [0,1,2,3,4,5], $runner->deadline, ['class'=>'form-control'] ) !!}
                                    </td>

                                    <td>
                                        <a href='#' class='remove_edit'>Remove</a>
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
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Admin: Add registrations</div>
                <div class="panel-body">
                    <button class="btn btn-success add_field_button">Add More Fields</button>
                    {!! Form::open(['method'=>'POST', 'route'=>['event.registration.store', $event->id], 'class'=>'form-inline', 'id'=>'registrationForm']) !!}
                    {!! Form::hidden('event_id', $event->id) !!}
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
                                <th>Payed</th>
                                @for($a=0; $a<$event->stages; $a++)
                                    <th>S-{{$a+1}}</th>
                                @endfor
                            </tr>
                            </thead>
                            <tbody id="input_registration">

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


    <a href="{{url('/event/'.$event->id.'/registration/admin')}}" class="btn btn-default">Back</a>
    <hr>
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script>
        $(document).ready(function () {


            $('.remove_edit').click(function (e) {
                e.preventDefault();
                $(this).parent().parent().remove();
            });

            var max_fields = 20; //maximum input boxes allowed

            var input_registration = $("#input_registration");
            var edit_rent_registration = $("#edit_rent_registration");
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
                    $(input_registration).append(' <tr> \
                            <td><input type="text" name="first_name[]" class="form-control" required  minlength="3" maxlength="30" id="first' + add + '"></td>\
                            <td><input type="text" name="last_name[]" class="form-control" required minlength="3" maxlength="30" id="last' + add + '"></td>\
                            <td> <select class="form-control" name="gender[]" required id="gender' + add + '">\
                                <option value="female">Female</option>\
                                <option value="male">Male</option>\
                                <option value="other">Other</option>\
                            </select></td>\
                            <td><input type="text" name="birth_year[]" class="form-control" required minlength="4" maxlength="4" id="year' + add + '"></td>\
                            <td><input type="text" name="club[]" class="form-control" required minlength="3" maxlength="30" id="club' + add + '"> </td>\
                            <td><input type="text" name="country[]" class="form-control" required minlength="3" maxlength="30" id="country' + add + '"></td>\
                            <td><select class="form-control" name="category[]" required id="category' + add + '">\
                                \@foreach($category as $cat)
                                <option value="{{$cat}}">{{$cat}}</option>\
                                \@endforeach
                            </select></td>\
                            <td><input type="text" name="si_chip[]" class="form-control" <?php if(!$event->si_rent){ echo('required');} ?> minlength="3" maxlength="30" id="chip' + add + '"></td>\
                            <td><select name="payed[]" class="form-control" required id="payed' + add + '">\
                            <option value="0">No</option>\
                            <option value="1">Yes</option>\
                            </select></td>\
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


            $(input_registration).on("click", ".remove_field", function (e) { //user click on remove text
                e.preventDefault();
                if (x > 2) {
                    $(this).closest('tr').remove();
                    x--;
                }
            });

        });
    </script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.2.0/list.min.js"></script>
    <script>
        var options = {
            valueNames: ['number', 'first_name', 'last_name', 'gender', 'birth_year', 'club', 'country', 'category', 'si_chip', 'payed', 's-1', 's-2', 's-3', 's-4', 's-5', 'deadline']
        };

        var userList = new List('runners', options);
    </script>
@stop