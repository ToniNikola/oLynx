@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h3>
                {{$event->name}}
            </h3>


        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-6">
            <a href="{{url('/event/'.$event->slug.'/registration/show')}}" class="btn btn-success">Registration
                List</a>
        </div>
        <div class="col-lg-6">
            @if($event->open)
                <a href="{{url('/event/'.$event->slug.'/registration/create')}}"
                   class="btn btn-primary">Registration</a>
            @else
                <div class="btn btn-default">Close for registration.</div>
            @endif
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-6">
            <section>
                <p>
                    <b> Start Date:</b> {{date("d-m-Y", strtotime($event->start_date))}} <br><br>
                    <b>End Date: </b>{{date("d-m-Y", strtotime($event->end_date))}} <br><br>
                    <b>Stages:</b> {{$event->stages}} <br><br>
                    <b>Category:</b><br> {{$event->category}}
                </p>
            </section>
        </div>
        <div class="col-lg-6">
            <section>
                
                <div class="table-responsive">
                    <h4>Deadlines</h4>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>Valid until</th>
                            <th>Stage Min*</th>
                            <th>Stage Max</th>
                            <th>All Stage Min*</th>
                            <th>All Stage Max</th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($a=0; $a<count($event->deadline); $a++)
                            <tr>
                                <td>
                                    {{$a+1}}.
                                </td>
                                <td>
                                    {{date("d-m-Y", strtotime($event->deadline[$a]->deadline))}}
                                </td>
                                <td>
                                    {{$value1[$a][0]}} &euro;
                                </td>
                                <td>
                                    {{$value1[$a][1]}} &euro;
                                </td>
                                <td>
                                    {{$value2[$a][1]}} &euro;
                                </td>
                                <td>
                                    {{$value2[$a][1]}} &euro;
                                </td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
                    *Entry fee for OPEN L, OPEN S, BEGINEERS, W10, M10, W12, M12, W14, M14, W16 and M16.
                </div>

            </section>
        </div>
    </div>
    <hr>
    <a href="{{url('/event/')}}" class="btn btn-default">Back</a>

@stop