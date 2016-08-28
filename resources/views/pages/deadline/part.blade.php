
    <td>
     {{$i+1}}.
    </td>
    <td>
        {!! Form::date("deadline[]", null,['class'=>'form-control']) !!}
    </td>
    <td>
        {!! Form::text('stage_min[]', null,['class'=>'form-control']) !!}
    </td>
    <td>
        {!! Form::text('stage_max[]',null, ['class'=>'form-control']) !!}
    </td>
    <td>
        {!! Form::text('all_min[]',null, ['class'=>'form-control']) !!}
    </td>
    <td>
        {!! Form::text('all_max[]', null,['class'=>'form-control']) !!}
    </td>
