<div class="row">
    <div class="form-group col-sm-6">
        {!! Form::label('flight_number', 'Flight Number/Route Code/Leg') !!}
        <div class="row">
            <div class="col-sm-4">
                {!! Form::text('flight_number', null, ['placeholder' => 'Flight Number', 'class' => 'form-control']) !!}
                <p class="text-danger">{{ $errors->first('flight_number') }}</p>
            </div>
            <div class="col-sm-4">
                {!! Form::text('route_code', null, ['placeholder' => 'Code (optional)', 'class' => 'form-control']) !!}
                <p class="text-danger">{{ $errors->first('route_code') }}</p>
            </div>
            <div class="col-sm-4">
                {!! Form::text('route_leg', null, ['placeholder' => 'Leg (optional)', 'class' => 'form-control']) !!}
                <p class="text-danger">{{ $errors->first('route_leg') }}</p>
            </div>
        </div>
    </div>
    <div class="form-group col-sm-6">
        <p class="description">Filed Using:</span>
        {!! PirepSource::label($pirep->source) !!}
        @if(filled($pirep->source_name))
            ({!! $pirep->source_name !!})
        @endif
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-3">
        {!! Form::label('airline_id', 'Airline') !!}
        <div class="row">
            <div class="col-sm-12">
                {!! Form::select('airline_id', $airlines, null, ['class' => 'form-control select2']) !!}
                <p class="text-danger">{{ $errors->first('airline_id') }}</p>
            </div>
        </div>
    </div>
    <div class="form-group col-sm-3">
        {!! Form::label('aircraft_id', 'Aircraft:') !!}
        {!! Form::select('aircraft_id', $aircraft, null, ['class' => 'form-control select2']) !!}
        <p class="text-danger">{{ $errors->first('aircraft_id') }}</p>
    </div>
    <div class="form-group col-sm-3">
        {!! Form::label('dpt_airport_id', 'Departure Airport:') !!}
        {!! Form::select('dpt_airport_id', $airports, null, ['class' => 'form-control select2']) !!}
        <p class="text-danger">{{ $errors->first('dpt_airport_id') }}</p>
    </div>

    <div class="form-group col-sm-3">
        {!! Form::label('arr_airport_id', 'Arrival Airport:') !!}
        {!! Form::select('arr_airport_id', $airports, null, ['class' => 'form-control select2']) !!}
        <p class="text-danger">{{ $errors->first('arr_airport_id') }}</p>
    </div>
</div>
<div class="row">
    <!-- Flight Time Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('flight_time', 'Flight Time (hours & minutes):') !!}
        <div class="row">
            <div class="col-sm-6">
                {!! Form::number('hours', null, ['class' => 'form-control', 'placeholder' => 'hours', 'readonly' => $read_only]) !!}
            </div>
            <div class="col-sm-6">
                {!! Form::number('minutes', null, ['class' => 'form-control', 'placeholder' => 'minutes', 'readonly' => $read_only]) !!}
            </div>
            <p class="text-danger">{{ $errors->first('hours') }}</p>
            <p class="text-danger">{{ $errors->first('minutes') }}</p>
        </div>
    </div>

    <!-- Level Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('level', 'Flight Level:') !!}
        <div class="row">
            <div class="col-sm-12">
                {!! Form::text('level', null, ['class' => 'form-control']) !!}
                <p class="text-danger">{{ $errors->first('level') }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Route Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('route', 'Route:') !!}
        {!! Form::textarea('route', null, ['class' => 'form-control']) !!}
        <p class="text-danger">{{ $errors->first('route') }}</p>
    </div>

    <!-- Notes Field -->
    <div class="form-group col-sm-6">
        {!! Form::label('notes', 'Notes:') !!}
        {!! Form::textarea('notes', null, ['class' => 'form-control']) !!}
        <p class="text-danger">{{ $errors->first('notes') }}</p>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-12">
        <div class="pull-right">
            {!! Form::button('Save', ['type' => 'submit', 'class' => 'btn btn-success']) !!}
            <a href="{!! route('admin.pireps.index') !!}" class="btn btn-warn">Cancel</a>
        </div>
    </div>
</div>
