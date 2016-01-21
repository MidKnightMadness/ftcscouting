<div class="form-group">
    <div class="form-group {!!$errors->first('submitter_name')? "has-error" : ""!!}">
        {!! Form::label('submitter_name', 'Submitter\'s Name', ['class'=>'control-label']) !!}
        {!!$errors->first('submitter_name', '<span class="help-block">:message</span>')!!}
        {!! Form::text('submitter_name', Cookie::has('submittersName')? Cookie::get('submittersName') : '', ['class'=>'form-control', Session::has('edit')? 'disabled' : '']) !!}
    </div>
    <div class="form-group {!!$errors->first('team_number')? 'has-error' : ''!!}", id="tn_div">
        {!! Form::label('team_number', 'Team Number', ['class'=>'control-label']) !!}
        <span class="help-block" id="tn_exist"></span>
        {!!$errors->first('team_number', '<span class="help-block">:message</span>')!!}
        {!! Form::input('phn', 'team_number', null, ['class'=>'form-control', 'id'=>'team_number']) !!}
    </div>
    {!! Form::label('team_name', 'Team Name')!!}
    {!! Form::text('team_name', null, ['class'=>'form-control']) !!}
    <hr/>
    <h2>Autonomous</h2>
    <div class="form-group {!!$errors->first('startig_loc')? 'has-error' : ''!!}">
        {!! Form::label('starting_loc', 'Conflicting autonomous start location', ['class'=>'control-label']) !!}
        {!!$errors->first('starting_loc', '<span class="help-block">:message</span>')!!}
        <div id="auto_start">
            {!! Form::radio('starting_loc', '0', true) !!} No<br/>
            {!! Form::radio('starting_loc', '1') !!} Yes<br/>
        </div>
    </div>
    <div class="form-group">
        {!! Form::checkbox('climbers_scored', 1, false, ['id'=>'c_s_a']) !!}
        {!! Form::label('climbers_scored', 'Can score climbers?') !!}
    </div>
    <div class="form-group">
        {!! Form::checkbox('beacon_scored') !!}
        {!! Form::label('beacon_scored', 'Can Score Beacon?') !!}
    </div>
    <div class="form-group {!!$errors->first('auto_zone')? 'has-error' : ''!!}">
        {!! Form::label('auto_park_zone', 'Autonomous Parking Location', ['class'=>'control-label']) !!}
        {!! $errors->first('auto_zone', '<span class="help-block">:message</span>')!!}
        <div id="auto_park_zone">
            {!! Form::radio('auto_zone', '0', true) !!} N/A<br/>
            {!! Form::radio('auto_zone', '1') !!} Floor Goal<br/>
            {!! Form::radio('auto_zone', '2') !!} Repair Zone<br>
            {!! Form::radio('auto_zone', '3') !!} Low Zone Touching Floor<br/>
            {!! Form::radio('auto_zone', '4') !!} Low Zone<br/>
            {!! Form::radio('auto_zone', '5') !!} Mid Zone<br/>
            {!! Form::radio('auto_zone', '6') !!} High Zone<br/>
        </div>
    </div>
    <hr/>
    <h2>Teleop</h2>
    <div class="form-group">
        {!! Form::checkbox('t_climbers_scored', 1, false, ['id'=>'c_s_t']) !!}
        {!! Form::label('t_climbers_scored', 'Can score climbers?') !!}
    </div>
    <div class="form-group {!!$errors->first('zl_climbers')? 'has-error' : ''!!}">
        {!! Form::label('zipline_climbers', 'Zipline Climbers Scored', ['class'=>'control-label']) !!}

        {!!$errors->first('zl_climbers', '<span class="help-block">:message</span>')!!}
        <div id="zipline_climbers">
            {!! Form::radio('zl_climbers', '0', true) !!} 0<br/>
            {!! Form::radio('zl_climbers', '1') !!} 1<br/>
            {!! Form::radio('zl_climbers', '2') !!} 2<br/>
            {!! Form::radio('zl_climbers', '3') !!} 3<br/>
        </div>
    </div>
    {!! Form::label('debris') !!}
    <div class="form-group" id="debris">
        {!! Form::checkbox('d_none', 1, true, ['id'=>'mcheck_default']) !!} None<br/>
        {!! Form::checkbox('d_fz', 1, false, ['class'=>'mcheck_o']) !!} Floor Goal<br/>
        {!! Form::checkbox('d_lz', 1, false, ['class'=>'mcheck_o']) !!} Low Goal<br/>
        {!! Form::checkbox('d_mz', 1, false, ['class'=>'mcheck_o']) !!} Mid Goal<br/>
        {!! Form::checkbox('d_hz', 1, false, ['class'=>'mcheck_o']) !!} High Goal<br/>
    </div>
    <hr/>
    <h2>End Game</h2>
    <div class="form-group">
        {!! Form::checkbox('all_clear') !!}
        {!! Form::label('all_clear', 'All Clear Signal') !!}
    </div>
    {!! Form::label('end_park', 'Final Parking Position') !!}
    <div class="form-group" id="end_park">
        {!! Form::checkbox('lz_f') !!} Low Zone touching floor<br/>
        {!! Form::checkbox('lz') !!} Low Zone<br/>
        {!! Form::checkbox('mz') !!} Mid Zone<br/>
        {!! Form::checkbox('hz') !!} High Zone<br/>
        {!! Form::checkbox('hang') !!} Hang<br/>
    </div>
    <hr/>
    <h2>Other</h2>
    <div class="form-group">
        {!! Form::label('other_info', 'Other information') !!}
        {!! Form::textarea('other_info', null, ['rows'=>'4', 'placeholder'=>'Other information', 'class'=>'form-control']) !!}
    </div>
    {!! Form::submit('Submit', ['class'=>'btn btn-success btn-block', 'id'=>'submit_button']) !!}
</div>