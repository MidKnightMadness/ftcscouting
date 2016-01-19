@extends('master')

@section('title')
    New Match
@stop

@section('subtitle')
    New Match Results
@stop
@section('js')
    <script type="text/javascript" src="{{asset('js/new_match.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/multi_check.js')}}"></script>
@stop
@section('content')
    {!! Form::open(['route'=>'match.new', 'method' => 'put']) !!}
    <div class="form-group" id="team_num_div">
        {!! Form::label('team_number', 'Team Number', ['class'=>'control-label']) !!}
        <span class="help-block" id="team_num_help"></span>
        {!! Form::input('tel', 'team_number', isset($_GET['team'])? $_GET['team'] : null, ['class'=>'form-control', 'id'=>'team_num']) !!}
    </div>
    <div class="form-group">
        {!! Form::checkbox('climbers_scored', 1, false, ['id'=>'c_s_a']) !!}
        {!! Form::label('climbers_scored', 'Scored Climbers') !!}
    </div>
    <div class="form-group">
        {!! Form::checkbox('beacon_scored') !!}
        {!! Form::label('beacon_scored', 'Scored Beacon') !!}
    </div>
    <div class="form-group">
        {!! Form::checkbox('t_climbers_scored', 1, false, ['id'=>'c_s_t']) !!}
        {!! Form::label('t_climbers_scored', 'Scored Climbers (Teleop)') !!}
    </div>
    {!! Form::label('zl', 'Zipline Climbers') !!}
    <div class="form-group" , id="zl">
        {!! Form::radio('zl_climbers', '0', true) !!} 0<br/>
        {!! Form::radio('zl_climbers', '1') !!} 1<br/>
        {!! Form::radio('zl_climbers', '2') !!} 2<br/>
        {!! Form::radio('zl_climbers', '3') !!} 3<br/>
    </div>
    {!! Form::label('d', 'Debris Scored') !!}
    <div class="form-group" , id="debris">
        {!! Form::checkbox('d_none', 1, true, ['id'=>'mcheck_default']) !!} None<br/>
        {!! Form::checkbox('d_fz', 1, false, ['class'=>'mcheck_o']) !!} Floor Goal<br/>
        {!! Form::checkbox('d_lz', 1, false, ['class'=>'mcheck_o']) !!} Low Goal<br/>
        {!! Form::checkbox('d_mz', 1, false, ['class'=>'mcheck_o']) !!} Mid Goal<br/>
        {!! Form::checkbox('d_hz', 1, false, ['class'=>'mcheck_o']) !!} High Goal<br/>
    </div>
    <div class="form-group">
        {!! Form::checkbox('all_clear') !!}
        {!! Form::label('allClear', 'All Clear Signal') !!}
    </div>
    <div class="form-group">
        {!! Form::checkbox('hang') !!}
        {!! Form::label('hang', 'Hang') !!}
    </div>
    {!! Form::submit('Save', ['class'=> 'btn btn-success btn-block', 'id'=>'submit_btn']) !!}
    {!! Form::close() !!}
@stop