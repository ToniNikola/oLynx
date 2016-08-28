@extends('layouts.app')
@section('content')

    <div class="row">
        <div class="col-lg-6">
            <h4>Registration List</h4>
        </div>
        <div class="col-lg-6"></div>
    </div>
    <div class="row">
        <hr>
        <div class="col-lg-12" id="runners">
            <input class="search form-group" placeholder="Search"/>


            <div class="table-responsive runners">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>
                            <a class="sort btn" data-sort="number">No.</a>
                        </th>
                        <th>
                            <a class="sort btn" data-sort="first_name">First Name</a>
                        </th>
                        <th>
                            <a class="sort btn" data-sort="last_name"> Last Name</a>
                        </th>
                        <th>
                            <a class="sort btn" data-sort="club">Club</a>
                        </th>
                        <th><a class="sort btn" data-sort="country">Country</a></th>
                        <th><a class="sort btn" data-sort="category">Category</a></th>
                        <th><a class="sort btn" data-sort="si_chip">Si Chip</a></th>
                        @for($a=0; $a<$stages_num; $a++)
                            <th><a class="sort btn" data-sort="s-{{$a+1}}">S-{{$a+1}}</a></th>
                        @endfor
                        <th><a class="sort btn" data-sort="deadline">Deadline</a></th>
                    </tr>
                    </thead>
                    <tbody class="list">
                    <?php $no = 1 ?>
                    @foreach($registration_list as $runner)
                        <tr>
                            <td class="number">{{$no}}.</td>
                            <td class="first_name">{{$runner->first_name}}</td>
                            <td class="last_name">{{$runner->last_name}}</td>
                            <td class="club">{{$runner->club}}</td>
                            <td class="country">{{$runner->country}}</td>
                            <td class="category">{{$runner->category}}</td>
                            <td class="si_chip">@if($runner->rented) R - @endif{{$runner->si_chip}}</td>
                            @for($b=0; $b<$stages_num; $b++)
                                @if($runner->stages[$b] == 0)
                                    <td class="s-{{$b+1}}">No</td>
                                @elseif($runner->stages[$b] == 1)
                                    <td class="s-{{$b+1}}">Early</td>
                                @elseif($runner->stages[$b] == 2)
                                    <td class="s-{{$b+1}}">Normal</td>
                                @elseif($runner->stages[$b] == 3)
                                    <td class="s-{{$b+1}}">Late</td>
                                @endif
                            @endfor
                            <td class="deadline">{{$runner->deadline}}</td>
                        </tr>
                        <?php $no ++ ?>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>
    <a href="{{url('/event/'.$slug)}}" class="btn btn-default">Back</a>
    <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.2.0/list.min.js"></script>
    <script>
        var options = {
            valueNames: ['number', 'first_name', 'last_name', 'club', 'country', 'category', 'si_chip', 's-1', 's-2', 's-3', 's-4', 's-5', 'deadline']
        };

        var userList = new List('runners', options);
    </script>

@stop