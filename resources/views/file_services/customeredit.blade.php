
{{--  @extends('account.layouts.default')  --}}
@extends('admin.layouts.default')
@section('admin.breadcrumb')
<li class='breadcrumb-item active'>File service</li>
@endsection
@section('content')
<div class="clearfix">

    <form method="POST" action="{{ route('file_services.update', $file_service->id) }}"  enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="card">
            <div class="card-header">
                <strong>Vihicle</strong> 
                <span class="center"> </span>
            </div>
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <div class="card-body">
            <div class="form-row">
            <div class="form-group{{ $errors->has('make') ? ' has-error' : '' }} col-md-2">
                <label for="make" class="control-label">Make</label>

                <input id="make" type="text"
                class="form-control{{ $errors->has('make') ? ' is-invalid' : '' }} "
                name="make"
                value="{{ old('make',$file_service->make) }}"  required="required">

                @if ($errors->has('make'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('make') }}</strong>
                    </div>
                @endif
            </div>



            <div class="form-group{{ $errors->has('model') ? ' has-error' : '' }} col-md-2">
                <label for="model" class="control-label">Model</label>

                <input id="model" type="text"
                        class="form-control{{ $errors->has('model') ? ' is-invalid' : '' }} "
                        name="model"
                        value="{{ old('model',$file_service->model) }}"  required="required">

                @if ($errors->has('model'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('model') }}</strong>
                    </div>
                @endif
            </div>

            <div class="form-group{{ $errors->has('generation') ? ' has-error' : '' }} col-md-2">
                <label for="generation" class="control-label">Generation</label>

                <input id="generation" type="text"
                        class="form-control{{ $errors->has('generation') ? ' is-invalid' : '' }} "
                        name="generation"
                        value="{{ old('generation',$file_service->generation) }}"  required="required">

                @if ($errors->has('generation'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('generation') }}</strong>
                    </div>
                @endif
            </div>

            
            <div class="form-group{{ $errors->has('engine') ? ' has-error' : '' }} col-md-2">
                <label for="engine" class="control-label">Engine</label>

                <input id="engine" type="text"
                        class="form-control{{ $errors->has('engine') ? ' is-invalid' : '' }} "
                        name="engine"
                        value="{{ old('engine',$file_service->engine) }}"  required="required">

                @if ($errors->has('engine'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('engine') }}</strong>
                    </div>
                @endif
            </div>

            <div class="form-group{{ $errors->has('ecu') ? ' has-error' : '' }} col-md-2">
                <label for="ecu" class="control-label">ECU</label>

                <input id="ecu" type="text"
                        class="form-control{{ $errors->has('ecu') ? ' is-invalid' : '' }} "
                        name="ecu"
                        value="{{ old('ecu',$file_service->ecu) }}"  required="required">

                @if ($errors->has('ecu'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('ecu') }}</strong>
                    </div>
                @endif
            </div>
        </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <strong>Vehicle details</strong> 
                <span class="center"> </span>
            </div>

            <div class="card-body">

        <div class="form-row">
            <div class="form-group{{ $errors->has('engine_hp') ? ' has-error' : '' }} col-md-6">
                <label for="engine_hp" class="control-label">Engine HP</label>

                <input id="engine_hp" type="text"
                        class="form-control{{ $errors->has('engine_hp') ? ' is-invalid' : '' }} "
                        name="engine_hp"
                        value="{{ old('engine_hp',$file_service->engine_hp) }}" >

                @if ($errors->has('engine_hp'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('engine_hp') }}</strong>
                    </div>
                @endif
            </div>

            <div class="form-group{{ $errors->has('engine_kw') ? ' has-error' : '' }} col-md-6">
                <label for="engine_kw" class="control-label">Engine KW</label>

                <input id="engine_kw" type="text"
                        class="form-control{{ $errors->has('engine_kw') ? ' is-invalid' : '' }} "
                        name="engine_kw"
                        value="{{ old('engine_kw',$file_service->engine_kw) }}">

                @if ($errors->has('engine_kw'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('engine_kw') }}</strong>
                    </div>
                @endif
            </div>
            
        </div>

        <div class="form-row">
            <div class="form-group{{ $errors->has('year') ? ' has-error' : '' }} col-md-6">
                <label for="year" class="control-label">Year</label>

                <input id="year" type="text"
                        class="form-control{{ $errors->has('year') ? ' is-invalid' : '' }} "
                        name="year"
                        value="{{ old('year',$file_service->year) }}"  >

                @if ($errors->has('year'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('year') }}</strong>
                    </div>
                @endif
            </div>

            <div class="form-group{{ $errors->has('gearbox') ? ' has-error' : '' }} col-md-6">
                <label for="gearbox" class="control-label">Gearbox</label>
                
                <select class="form-control{{ $errors->has('gearbox') ? ' is-invalid' : '' }} " required="required" id="gearbox" name="gearbox">
                    @foreach($gearboxes as $gearboxe)
                    <option value="{{ $gearboxe->id }}" {{ $gearboxe->id  == $file_service->gearbox ? 'selected="selected"' : '' }}>{{ $gearboxe->gbName}}</option>
                    @endforeach
                </select>

                @if ($errors->has('gearbox'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('gearbox') }}</strong>
                    </div>
                @endif
            </div>
            
        </div>

        <div class="form-row">
            <div class="form-group{{ $errors->has('license_plate') ? ' has-error' : '' }} col-md-6">
                <label for="license_plate" class="control-label">License Plate</label>

                <input id="license_plate" type="text"
                        class="form-control{{ $errors->has('license_plate') ? ' is-invalid' : '' }} "
                        name="license_plate"
                        value="{{ old('license_plate',$file_service->license_plate) }}"  autofocus>

                @if ($errors->has('license_plate'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('license_plate') }}</strong>
                    </div>
                @endif
            </div>

            <div class="form-group{{ $errors->has('vin') ? ' has-error' : '' }} col-md-6">
                <label for="vin" class="control-label">VIN</label>

                <input id="vin" type="text"
                        class="form-control{{ $errors->has('vin') ? ' is-invalid' : '' }} "
                        name="vin"
                        value="{{ old('vin',$file_service->vin) }}"  autofocus>

                @if ($errors->has('vin'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('vin') }}</strong>
                    </div>
                @endif
            </div>
            
        </div>

        <div class="from-row">
            <div class="form-group{{ $errors->has('fuel_octane_rating') ? ' has-error' : '' }}">
                <label for="fuel_octane_rating" class="control-label">Fuel octane rating</label>

                <input id="fuel_octane_rating" type="text"
                        class="form-control{{ $errors->has('fuel_octane_rating') ? ' is-invalid' : '' }} "
                        name="fuel_octane_rating"
                        value="{{ old('fuel_octane_rating',$file_service->fuel_octane_rating) }}"  autofocus>

                @if ($errors->has('fuel_octane_rating'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('fuel_octane_rating') }}</strong>
                    </div>
                @endif
            </div>
            
        </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <strong>ECU details</strong> 
                <span class="center"> </span>
            </div>
            
            <div class="card-body">

        <div class="from-row">
            <div class="form-group{{ $errors->has('read_method') ? ' has-error' : '' }}">
                <label for="read_method" class="control-label">Read Method</label>
                
                <select class="form-control{{ $errors->has('read_method') ? ' is-invalid' : '' }} " required="required" id="read_method" name="read_method">
                    <option value="">Choose a tuning type</option>
                    @foreach($readmethods as $readmethod)
                    <option value="{{ $readmethod->id }}" {{ $readmethod->id  == $file_service->read_method ? 'selected="selected"' : '' }}>{{ $readmethod->read_method_name }}</option>
                    @endforeach
                </select>

                @if ($errors->has('read_method'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('read_method') }}</strong>
                    </div>
                @endif
            </div>

            <div class="form-group{{ $errors->has('tuning_type') ? ' has-error' : '' }}">
                <label for="tuning_type" class="control-label">Tuning Type</label>
                
                <select class="form-control{{ $errors->has('tuning_type') ? ' is-invalid' : '' }} click" required="required" id="tuning_type" name="tuning_type">
                    <option value="">Choose a tuning type</option>
                        @foreach($tuning_types as $tuning_type)
                        <option value="{{ $tuning_type->id }}" {{ $tuning_type->id  == $file_service->tuning_type ? 'selected="selected"' : '' }}>{{ $tuning_type->label }}</option>
                        @endforeach
                </select>

                @if ($errors->has('tuning_type')) 
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('tuning_type') }}</strong>
                    </div>
                @endif
            </div>
        </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <strong>File</strong> 
                <span class="center"> </span>
            </div>

            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="status" class="control-label">Attachment (optional)
                          Only files smaller than 10MB <span class="text-danger">*</span></label>
                    <div class="row">
                        <div class="col-md-4 col-6">
                            <div class="dropzone-wrapper1">
                                <div class="dropzone-desc1">
                                    <div class="exist">
                                        <p id="empltyoriginalFile1"> No file uploaded yet  </p>
                                    </div>
                                    <div class="notExist">
                                        <p id="empltyoriginalFile"> No file uploaded yet  </p>
                                        <p id="originalFile"> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-6">
                        <div class="form-group">
                            
                            <div class="dropzone-wrapper">
                            <div class="dropzone-desc">
                                <i class="fa fa-file"></i>
                                <p>Drop your file(s) here <br> </p>
                                <p class="btn btn-secondary clickButton">or click to browse</p>
                                
                            </div>
                            <input type="file" name="file_to_modify" id="file_to_modify" class="dropzone" onchange="readURL(this);">
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="existFile">
                            <div class="col-md-1 col-1">
                            </div>
                        </div>
                        <div class="existFile">
                            <div class="col-md-1 col-1">
                            </div>
                        </div>
            
                        <div class="notExistFile">
                            <div class="col-md-1 col-1 import">
                            </div>
                        </div>
                        <div class="notExistFile ">
                            <div class="col-md-1 col-1 deleteOriginalFile">
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <strong>Service</strong> 
                <span class="center"> </span>
            </div>
            
            <div class="card-body">

                <div class="from-row">
                    <div class="form-group{{ $errors->has('timeframe') ? ' has-error' : '' }}">
                        <label for="timeframe" class="control-label">Timeframe</label>
                        

                        <select class="form-control{{ $errors->has('timeframe') ? ' is-invalid' : '' }} " required="required" id="timeframe" name="timeframe">
                            <option value="ASAP" @if($file_service->timeframe == 'ASAP') selected @endif>ASAP</option>
                            <option value="2-3 hours" @if($file_service->timeframe == '2-3 hours') selected @endif>2-3 hours</option>
                            <option value="5-6 hours" @if($file_service->timeframe == '5-6 hours') selected @endif>5-6 hours</option>
                        </select>

                        @if ($errors->has('timeframe'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('timeframe') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('dyno') ? ' has-error' : '' }}">
                        <label for="dyno" class="control-label">Dyno</label>
                        
                        <select class="form-control{{ $errors->has('dyno') ? ' is-invalid' : '' }} " required="required" id="dyno" name="dyno">
                            <option value="0" @if($file_service->dyno == '0') selected @endif>No</option>
                            <option value="1" @if($file_service->dyno == '1') selected @endif>Yes</option>
                        </select>

                        @if ($errors->has('dyno'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('dyno') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('info') ? ' has-error' : '' }}">
                        <label for="info" class="control-label">Dyno <span>(optional)</span></label>

                        <textarea id="info" type="text" class="form-control{{ $errors->has('info') ? ' is-invalid' : '' }} " name="info" >{{ old('info',$file_service->info) }}</textarea>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" onclick="this.disabled=true;this.form.submit();">
                        Save  
                    </button>
                </div>
            </div>
        </div>
        
    </form>
</div>
@endsection