@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h4>Manage rented</h4>
        </div>
    </div>
    <div class="row">
        <div>
            <hr>
            <div class="col-md-12" id="runners">
                <div class="panel panel-default">
                    <div class="panel-heading">Admin: Manage Si-Chip Rent<span
                                style="float:right">Total rented runners:{{$rent_num}} </span></div>
                    <div class="panel-body">
                        <hr>
                        <input class="search form-group" placeholder="Search"/>
                        <hr>
                        {!! Form::open(['method'=>'PATCH', 'route'=>['event.registration.update', $event->id, 0], 'class'=>'form-inline']) !!}
                        {!! Form::hidden('event_id', $event->id) !!}
                        {!! Form::hidden('runner_id', $runner_id) !!}
                        {!! Form::hidden('rented', true) !!}
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
                                <tbody class="list" id="edit-rent-registration">
                                <?php $num = 1; ?>
                                @foreach($registration_list as $runner)
                                    @if($runner->rented)
                                        <tr>
                                            {!! Form::hidden('id[]', $runner->id) !!}
                                            <td class="number">
                                                {{$num++}}.
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
                                                {!! Form::select('category[]', $category,$runner->category, ['class'=>'form-control']) !!}
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

                                        </tr>
                                    @endif
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
            <hr>
            <a href="{{url('/event/'.$event->id.'/registration/admin')}}" class="btn btn-default">Back</a>

            <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.2.0/list.min.js"></script>
            <script>
                var options = {
                    valueNames: ['number', 'first_name', 'last_name', 'club', 'country', 'category', 'si_chip', 's-1', 's-2', 's-3', 's-4', 's-5', 'deadline']
                };

                var userList = new List('runners', options);
            </script>


@stop