<div class="form-group">
    {!! Form::label('submitter_name', 'Submitter\'s Name') !!}
    {!! Form::text('submitter_name', Cookie::has('submittersName')? Cookie::get('submittersName') : null, ['class'=>'form-control', Session::has('edit')? 'disabled' : '']) !!}
    {!! Form::label('team_number', 'Team Number') !!}
    {!! Form::input('tel', 'team_number', null, ['class'=>'form-control']) !!}
    {!! Form::label('team_name', 'Team Name')!!}
    {!! Form::text('team_name', null, ['class'=>'form-control']) !!}
    <hr/>
    <h2>Autonomous</h2>
    <div class="form-group">
        {!! Form::label('starting_loc', 'Starting Location') !!}
        {!! Form::text('starting_loc', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::checkbox('climbers_scored') !!}
        {!! Form::label('climbers_scored', 'Can score climbers?') !!}
    </div>
    <div class="form-group">
        {!! Form::checkbox('beacon_scored') !!}
        {!! Form::label('beacon_scored', 'Can Score Beacon?') !!}
    </div>
    {!! Form::label('auto_park_zone', 'Autonomous Parking Location') !!}
    <div class="form-group" id="auto_park_zone">
        {!! Form::radio('auto_zone', '0') !!} N/A<br/>
        {!! Form::radio('auto_zone', '1') !!} Repair Zone<br>
        {!! Form::radio('auto_zone', '2') !!} Low Zone<br/>
        {!! Form::radio('auto_zone', '3') !!} Mid Zone<br/>
        {!! Form::radio('auto_zone', '4') !!} High Zone<br/>
    </div>
    <hr/>
    <h2>Teleop</h2>
    <div class="form-group">
        {!! Form::checkbox('t_climbers_scored') !!}
        {!! Form::label('t_climbers_scored', 'Can score climbers?') !!}
    </div>
    {!! Form::label('zipline_climbers', 'Zipline Climbers Scored') !!}
    <div class="form-group" id="zipline_climbers">
        {!! Form::radio('zl_climbers', '0', true) !!} 0<br/>
        {!! Form::radio('zl_climbers', '1') !!} 1<br/>
        {!! Form::radio('zl_climbers', '2') !!} 2<br/>
        {!! Form::radio('zl_climbers', '3') !!} 3<br/>
    </div>
    {!! Form::label('debris') !!}
    <div class="form-group" id="debris">
        {!! Form::checkbox('d_none', 1, true) !!} None<br/>
        {!! Form::checkbox('d_fz') !!} Floor Goal<br/>
        {!! Form::checkbox('d_lz') !!} Low Goal<br/>
        {!! Form::checkbox('d_mz') !!} Mid Goal<br/>
        {!! Form::checkbox('d_hz') !!} High Goal<br/>
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
{!! Form::submit('Submit', ['class'=>'btn btn-success btn-block']) !!}
</div>