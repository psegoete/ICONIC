<form method="POST" action="{{ route('availability') }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('day') ? ' has-error' : '' }} row">
        <div class="col-md-3">
            <label class="col-form-label" for="monday">Day</label>
            <input type="text" id="monday" name="monday" class="form-control{{ $errors->has('monday') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('monday', $Availability->monday) }}" disabled>

                @if ($errors->has('monday'))
                    <span class="text-danger">{{ $errors->first('monday') }}</span>
                @endif
        </div>
        <div class="col-md-3">
            <label class="col-form-label" for="monday_opening_time">From</label>
            <input type="time" id="monday_opening_time" name="monday_opening_time" class="form-control{{ $errors->has('monday_opening_time') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('monday_opening_time', $Availability->monday_opening_time) }}">

                @if ($errors->has('monday_opening_time'))
                    <span class="text-danger">{{ $errors->first('monday_opening_time') }}</span>
                @endif
        </div>
        <div class="col-md-3">
            <label class="col-form-label" for="monday_closing_time">To</label>
            <input type="time" id="monday_closing_time" name="monday_closing_time" class="form-control{{ $errors->has('monday_closing_time') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('monday_closing_time', $Availability->monday_closing_time) }}">

                @if ($errors->has('monday_closing_time'))
                    <span class="text-danger">{{ $errors->first('monday_closing_time') }}</span>
                @endif
        </div>

        <div class="col-md-1">
            <label class="col-form-label" for="monday_status">Closed</label>
            <input type="checkbox" id="monday_status" name="monday_status" class="form-control{{ $errors->has('monday_status') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="1" @if ($Availability->monday_status == '1')) checked="checked" @endif>

                @if ($errors->has('monday_status'))
                    <span class="text-danger">{{ $errors->first('monday_status') }}</span>
                @endif
        </div>
    </div>
    {{-- Tuesday --}}
    <div class="form-group{{ $errors->has('day') ? ' has-error' : '' }} row">
        <div class="col-md-3">
            <label class="col-form-label" for="tuesday">Day</label>
            <input type="text" id="tuesday" name="tuesday" class="form-control{{ $errors->has('tuesday') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('tuesday', $Availability->tuesday) }}" disabled>

                @if ($errors->has('tuesday'))
                    <span class="text-danger">{{ $errors->first('tuesday') }}</span>
                @endif
        </div>
        <div class="col-md-3">
            <label class="col-form-label" for="tuesday_opening_time">From</label>
            <input type="time" id="tuesday_opening_time" name="tuesday_opening_time" class="form-control{{ $errors->has('tuesday_opening_time') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('tuesday_opening_time', $Availability->tuesday_opening_time) }}">

                @if ($errors->has('tuesday_opening_time'))
                    <span class="text-danger">{{ $errors->first('tuesday_opening_time') }}</span>
                @endif
        </div>
        <div class="col-md-3">
            <label class="col-form-label" for="tuesday_closing_time">To</label>
            <input type="time" id="tuesday_closing_time" name="tuesday_closing_time" class="form-control{{ $errors->has('tuesday_closing_time') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('tuesday_closing_time', $Availability->tuesday_closing_time) }}">

                @if ($errors->has('tuesday_closing_time'))
                    <span class="text-danger">{{ $errors->first('tuesday_closing_time') }}</span>
                @endif
        </div>

        <div class="col-md-1">
            <label class="col-form-label" for="tuesday_status">Closed</label>
            <input type="checkbox" id="tuesday_status" name="tuesday_status" class="form-control{{ $errors->has('tuesday_status') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="1" @if ($Availability->tuesday_status == '1')) checked="checked" @endif>

                @if ($errors->has('tuesday_status'))
                    <span class="text-danger">{{ $errors->first('tuesday_status') }}</span>
                @endif
        </div>
    </div>
    {{-- Wednesday --}}
    <div class="form-group{{ $errors->has('day') ? ' has-error' : '' }} row">
        <div class="col-md-3">
            <label class="col-form-label" for="wednesday">Day</label>
            <input type="text" id="wednesday" name="wednesday" class="form-control{{ $errors->has('wednesday') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('wednesday', $Availability->wednesday) }}" disabled>

                @if ($errors->has('wednesday'))
                    <span class="text-danger">{{ $errors->first('wednesday') }}</span>
                @endif
        </div>
        <div class="col-md-3">
            <label class="col-form-label" for="wednesday_opening_time">From</label>
            <input type="time" id="wednesday_opening_time" name="wednesday_opening_time" class="form-control{{ $errors->has('wednesday_opening_time') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('wednesday_opening_time', $Availability->wednesday_opening_time) }}">

                @if ($errors->has('wednesday_opening_time'))
                    <span class="text-danger">{{ $errors->first('wednesday_opening_time') }}</span>
                @endif
        </div>
        <div class="col-md-3">
            <label class="col-form-label" for="wednesday_closing_time">To</label>
            <input type="time" id="wednesday_closing_time" name="wednesday_closing_time" class="form-control{{ $errors->has('wednesday_closing_time') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('wednesday_closing_time', $Availability->wednesday_closing_time) }}">

                @if ($errors->has('wednesday_closing_time'))
                    <span class="text-danger">{{ $errors->first('wednesday_closing_time') }}</span>
                @endif
        </div>

        <div class="col-md-1">
            <label class="col-form-label" for="wednesday_status">Closed</label>
            <input type="checkbox" id="wednesday_status" name="wednesday_status" class="form-control{{ $errors->has('wednesday_status') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="1" @if ($Availability->wednesday_status == '1')) checked="checked" @endif>

                @if ($errors->has('wednesday_status'))
                    <span class="text-danger">{{ $errors->first('wednesday_status') }}</span>
                @endif
        </div>
    </div>
    {{-- Thursday --}}
    <div class="form-group{{ $errors->has('day') ? ' has-error' : '' }} row">
        <div class="col-md-3">
            <label class="col-form-label" for="thursday">Day</label>
            <input type="text" id="thursday" name="thursday" class="form-control{{ $errors->has('thursday') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('thursday', $Availability->thursday) }}" disabled>

                @if ($errors->has('thursday'))
                    <span class="text-danger">{{ $errors->first('thursday') }}</span>
                @endif
        </div>
        <div class="col-md-3">
            <label class="col-form-label" for="thursday_opening_time">From</label>
            <input type="time" id="thursday_opening_time" name="thursday_opening_time" class="form-control{{ $errors->has('thursday_opening_time') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('thursday_opening_time', $Availability->thursday_opening_time) }}">

                @if ($errors->has('thursday_opening_time'))
                    <span class="text-danger">{{ $errors->first('thursday_opening_time') }}</span>
                @endif
        </div>
        <div class="col-md-3">
            <label class="col-form-label" for="thursday_closing_time">To</label>
            <input type="time" id="thursday_closing_time" name="thursday_closing_time" class="form-control{{ $errors->has('thursday_closing_time') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('thursday_closing_time', $Availability->thursday_closing_time) }}">

                @if ($errors->has('thursday_closing_time'))
                    <span class="text-danger">{{ $errors->first('thursday_closing_time') }}</span>
                @endif
        </div>

        <div class="col-md-1">
            <label class="col-form-label" for="thursday_status">Closed</label>
            <input type="checkbox" id="thursday_status" name="thursday_status" class="form-control{{ $errors->has('thursday_status') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="1" @if ($Availability->thursday_status == '1')) checked="checked" @endif>

                @if ($errors->has('thursday_status'))
                    <span class="text-danger">{{ $errors->first('thursday_status') }}</span>
                @endif
        </div>
    </div>
    {{-- Friday --}}
    <div class="form-group{{ $errors->has('day') ? ' has-error' : '' }} row">
        <div class="col-md-3">
            <label class="col-form-label" for="friday">Day</label>
            <input type="text" id="friday" name="friday" class="form-control{{ $errors->has('friday') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('friday', $Availability->friday) }}" disabled>

                @if ($errors->has('friday'))
                    <span class="text-danger">{{ $errors->first('friday') }}</span>
                @endif
        </div>
        <div class="col-md-3">
            <label class="col-form-label" for="friday_opening_time">From</label>
            <input type="time" id="friday_opening_time" name="friday_opening_time" class="form-control{{ $errors->has('friday_opening_time') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('friday_opening_time', $Availability->friday_opening_time) }}">

                @if ($errors->has('friday_opening_time'))
                    <span class="text-danger">{{ $errors->first('friday_opening_time') }}</span>
                @endif
        </div>
        <div class="col-md-3">
            <label class="col-form-label" for="friday_closing_time">To</label>
            <input type="time" id="friday_closing_time" name="friday_closing_time" class="form-control{{ $errors->has('friday_closing_time') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('friday_closing_time', $Availability->friday_closing_time) }}">

                @if ($errors->has('friday_closing_time'))
                    <span class="text-danger">{{ $errors->first('friday_closing_time') }}</span>
                @endif
        </div>

        <div class="col-md-1">
            <label class="col-form-label" for="friday_status">Closed</label>
            <input type="checkbox" id="friday_status" name="friday_status" class="form-control{{ $errors->has('friday_status') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="1" @if ($Availability->friday_status == '1')) checked="checked" @endif>

                @if ($errors->has('friday_status'))
                    <span class="text-danger">{{ $errors->first('friday_status') }}</span>
                @endif
        </div>
    </div>
    {{-- Saturday --}}
    <div class="form-group{{ $errors->has('day') ? ' has-error' : '' }} row">
        <div class="col-md-3">
            <label class="col-form-label" for="saturday">Day</label>
            <input type="text" id="saturday" name="saturday" class="form-control{{ $errors->has('saturday') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('saturday', $Availability->saturday) }}" disabled>

                @if ($errors->has('saturday'))
                    <span class="text-danger">{{ $errors->first('saturday') }}</span>
                @endif
        </div>
        <div class="col-md-3">
            <label class="col-form-label" for="saturday_opening_time">From</label>
            <input type="time" id="saturday_opening_time" name="saturday_opening_time" class="form-control{{ $errors->has('saturday_opening_time') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('saturday_opening_time', $Availability->saturday_opening_time) }}">

                @if ($errors->has('saturday_opening_time'))
                    <span class="text-danger">{{ $errors->first('saturday_opening_time') }}</span>
                @endif
        </div>
        <div class="col-md-3">
            <label class="col-form-label" for="saturday_closing_time">To</label>
            <input type="time" id="saturday_closing_time" name="saturday_closing_time" class="form-control{{ $errors->has('saturday_closing_time') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('saturday_closing_time', $Availability->saturday_closing_time) }}">

                @if ($errors->has('saturday_closing_time'))
                    <span class="text-danger">{{ $errors->first('saturday_closing_time') }}</span>
                @endif
        </div>

        <div class="col-md-1">
            <label class="col-form-label" for="saturday_status">Closed</label>
            <input type="checkbox" id="saturday_status" name="saturday_status" class="form-control{{ $errors->has('saturday_status') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="1" @if ($Availability->saturday_status == '1')) checked="checked" @endif>

                @if ($errors->has('saturday_status'))
                    <span class="text-danger">{{ $errors->first('saturday_status') }}</span>
                @endif
        </div>
    </div>
    {{-- Sunday --}}
    <div class="form-group{{ $errors->has('day') ? ' has-error' : '' }} row">
        <div class="col-md-3">
            <label class="col-form-label" for="sunday">Day</label>
            <input type="text" id="sunday" name="sunday" class="form-control{{ $errors->has('sunday') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('sunday', $Availability->sunday) }}" disabled>

                @if ($errors->has('sunday'))
                    <span class="text-danger">{{ $errors->first('sunday') }}</span>
                @endif
        </div>
        <div class="col-md-3">
            <label class="col-form-label" for="sunday_opening_time">From</label>
            <input type="time" id="sunday_opening_time" name="sunday_opening_time" class="form-control{{ $errors->has('sunday_opening_time') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('sunday_opening_time', $Availability->sunday_opening_time) }}">

                @if ($errors->has('sunday_opening_time'))
                    <span class="text-danger">{{ $errors->first('sunday_opening_time') }}</span>
                @endif
        </div>
        <div class="col-md-3">
            <label class="col-form-label" for="sunday_closing_time">To</label>
            <input type="time" id="sunday_closing_time" name="sunday_closing_time" class="form-control{{ $errors->has('sunday_closing_time') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('sunday_closing_time', $Availability->sunday_closing_time) }}">

                @if ($errors->has('sunday_closing_time'))
                    <span class="text-danger">{{ $errors->first('sunday_closing_time') }}</span>
                @endif
        </div>

        <div class="col-md-1">
            <label class="col-form-label" for="sunday_status">Closed</label>
            <input type="checkbox" id="sunday_status" name="sunday_status" class="form-control{{ $errors->has('sunday_status') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="1" @if ($Availability->sunday_status == '1')) checked="checked" @endif>

                @if ($errors->has('sunday_status'))
                    <span class="text-danger">{{ $errors->first('sunday_status') }}</span>
                @endif
        </div>
    </div>
    {{-- Holiday --}}
    <div class="form-group{{ $errors->has('day') ? ' has-error' : '' }} row">
        <div class="col-md-3">
            <label class="col-form-label" for="holiday">Day</label>
            <input type="text" id="holiday" name="holiday" class="form-control{{ $errors->has('holiday') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('holiday', $Availability->holiday) }}" disabled>

                @if ($errors->has('holiday'))
                    <span class="text-danger">{{ $errors->first('holiday') }}</span>
                @endif
        </div>
        <div class="col-md-3">
            <label class="col-form-label" for="holiday_opening_time">From</label>
            <input type="time" id="holiday_opening_time" name="holiday_opening_time" class="form-control{{ $errors->has('holiday_opening_time') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('holiday_opening_time', $Availability->holiday_opening_time) }}">

                @if ($errors->has('holiday_opening_time'))
                    <span class="text-danger">{{ $errors->first('holiday_opening_time') }}</span>
                @endif
        </div>
        <div class="col-md-3">
            <label class="col-form-label" for="holiday_closing_time">To</label>
            <input type="time" id="holiday_closing_time" name="holiday_closing_time" class="form-control{{ $errors->has('holiday_closing_time') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="{{ old('holiday_closing_time', $Availability->holiday_closing_time) }}">

                @if ($errors->has('holiday_closing_time'))
                    <span class="text-danger">{{ $errors->first('holiday_closing_time') }}</span>
                @endif
        </div>

        <div class="col-md-1">
            <label class="col-form-label" for="holiday_status">Closed</label>
            <input type="checkbox" id="holiday_status" name="holiday_status" class="form-control{{ $errors->has('holiday_status') ? ' is-invalid' : '' }} "
                placeholder="Enter name" required
                value="1" @if ($Availability->holiday_status == '1')) checked="checked" @endif>

                @if ($errors->has('holiday_status'))
                    <span class="text-danger">{{ $errors->first('holiday_status') }}</span>
                @endif
        </div>
    </div>

    

    <div class="form-group">
        <button type="submit" class="btn btn-sm btn-primary" onclick="this.disabled=true;this.form.submit();">
            Save
        </button>
    </div>
</form>