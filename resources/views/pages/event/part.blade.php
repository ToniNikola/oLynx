<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Event Name</label>

    <div class="col-md-6">
        {!! Form::text('name',null, ['class'=>'form-control']) !!}
        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>
<div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Location</label>

    <div class="col-md-6">
        {!! Form::text('location',null, ['class'=>'form-control']) !!}

        @if ($errors->has('location'))
            <span class="help-block">
                                        <strong>{{ $errors->first('location') }}</strong>
                                    </span>
        @endif
    </div>
</div>
<div class="form-group{{ $errors->has('deadlines') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Deadlines</label>

    <div class="col-md-6">
        {!! Form::select('deadlines',[1=>1,2=>2,3=>3,4=>4,5=>5], null, ['class'=>'form-control']) !!}

        @if ($errors->has('deadlines'))
            <span class="help-block">
                                        <strong>{{ $errors->first('deadlines') }}</strong>
                                    </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('stages') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Stages</label>

    <div class="col-md-6">
        {!! Form::select('stages',[1=>1,2=>2,3=>3,4=>4,5=>5], null, ['class'=>'form-control']) !!}

        @if ($errors->has('stages'))
            <span class="help-block">
                                        <strong>{{ $errors->first('stages') }}</strong>
                                    </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Category</label>

    <div class="col-md-6">
        <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true">
                <span class="caret"></span>
            </button>

            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                @foreach($category as $cat)
                    <li>
                        {!! Form::label('Category', $cat) !!}
                        {!! Form::checkbox("category[]",  $cat, $category_set,null, ['class'=> 'form-control']) !!}
                    </li>
                @endforeach
            </ul>
        </div>

        @if ($errors->has('category'))
            <span class="help-block">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Start Date</label>

    <div class="col-md-6">
        <input type="date" class="form-control" name="start_date">

        @if ($errors->has('start_date'))
            <span class="help-block">
                                        <strong>{{ $errors->first('start_date') }}</strong>
                                    </span>
        @endif
    </div>
</div>
<div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Start Date</label>

    <div class="col-md-6">
        <input type="date" class="form-control" name="end_date">

        @if ($errors->has('end_date'))
            <span class="help-block">
                                        <strong>{{ $errors->first('end_date') }}</strong>
                                    </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('si_rent') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Si-chip Rent</label>

    <div class="col-md-6">
        {!! Form::radio('si_rent', '1') !!} Yes
        {!! Form::radio('si_rent', '0') !!} No


        @if ($errors->has('si_rent'))
            <span class="help-block">
                                        <strong>{{ $errors->first('si_rent') }}</strong>
                                    </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('event_img') ? ' has-error' : '' }}">
    <label class="col-md-4 control-label">Event Image</label>

    <div class="col-md-6">
        {!! Form::file('event_img') !!}
        @if ($errors->has('event_img'))
            <span class="help-block">
                                        <strong>{{ $errors->first('event_img') }}</strong>
                                    </span>
        @endif
    </div>
</div>