<div class="form-group">
    {!! Form::label('submitterName', 'Submitter\'s Name') !!}
    {!! Form::text('submitterName', Cookie::has('submittersName')? Cookie::get('submittersName') : null, ['class'=>'form-control', Session::has('edit')? 'disabled' : '']) !!}
    {!! Form::label('teamNumber', 'Team Number') !!}
    {!! Form::input('tel', 'teamNumber', null, ['class'=>'form-control']) !!}
    {!! Form::label('teamName', 'Team Name')!!}
    {!! Form::text('teamName', null, ['class'=>'form-control']) !!}
    <hr/>
    <h2>Autonomous</h2>
    <div class="form-group">
        {!! Form::label('startingLoc', 'Starting Location') !!}
        {!! Form::text('startingLoc', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::checkbox('climbersScored') !!}
        {!! Form::label('climbersScored', 'Can score climbers?') !!}
    </div>
    <div class="form-group">
        {!! Form::checkbox('beaconScored') !!}
        {!! Form::label('beaconScored', 'Can Score Beacon?') !!}
    </div>
    {!! Form::label('auto_park_zone', 'Autonomous Parking Location') !!}
    <div class="form-group" id="auto_park_zone">
        {!! Form::radio('autoZone', '0') !!} N/A<br/>
        {!! Form::radio('autoZone', '1') !!} Repair Zone<br>
        {!! Form::radio('autoZone', '2') !!} Low Zone<br/>
        {!! Form::radio('autoZone', '3') !!} Mid Zone<br/>
        {!! Form::radio('autoZone', '4') !!} High Zone<br/>
    </div>
    <hr/>
    <h2>Teleop</h2>
    <div class="form-group">
        {!! Form::checkbox('t_climberScored') !!}
        {!! Form::label('t_climberScored', 'Can score climbers?') !!}
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
        {!! Form::checkbox('d_none', null, true) !!} None<br/>
        {!! Form::checkbox('d_fz') !!} Floor Goal<br/>
        {!! Form::checkbox('d_lz') !!} Low Goal<br/>
        {!! Form::checkbox('d_mz') !!} Mid Goal<br/>
        {!! Form::checkbox('d_hz') !!} High Goal<br/>
    </div>
    <hr/>
    <h2>End Game</h2>
    <div class="form-group">
        {!! Form::checkbox('allClear') !!}
        {!! Form::label('allClear', 'All Clear Signal') !!}
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
        {!! Form::label('otherInfo', 'Other information') !!}
        {!! Form::textarea('otherInfo', null, ['rows'=>'4', 'placeholder'=>'Other information', 'class'=>'form-control']) !!}
    </div>
{!! Form::submit('Submit', ['class'=>'btn btn-success btn-block']) !!}