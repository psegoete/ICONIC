{{--  @extends('account.layouts.default')  --}}
@extends('admin.layouts.default')
@section('admin.breadcrumb')
<li class="breadcrumb-item">
        <a href="{{ route('file_services.index') }}">File services</a>
    </li>
<li class='breadcrumb-item '>New file services</li>
@endsection
@section('content')
<div class="clearfix">

    <form method="POST" action="{{ route('file_services.store') }}" enctype="multipart/form-data">
        @if( currentCredits() > 0)
        {{ csrf_field() }}
        @endif
        @if( currentCredits() <= 0)

        <div class="card">
            <div class="card-body">
                <div class="text-danger">
                    You do not have sufficient credits to submit a new file service. Please buy more credits first.
                </div>
            </div>
        </div>
        @endif
        @if(($deliveryTime->minimum_time && $deliveryTime->maximum_time) && $status == "OPEN" && currentCredits() > 0)
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="">
                        The estimated delivery time is {{ \Carbon\CarbonInterval::hours($deliveryTime->minimum_time/60)->minutes($deliveryTime->minimum_time%60)->forHumans()  }} - {{ \Carbon\CarbonInterval::hours($deliveryTime->maximum_time/60)->minutes($deliveryTime->maximum_time%60)->forHumans()}}
                    </div>
                </div>
            </div>
        @endif
        @if($status == "CLOSED" && currentCredits() > 0)
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="">
                        Please note that the file will be on the queue and it will the attended on the next business day.
                    </div>
                </div>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <strong>Vehicle</strong> 
                <span class="center"> </span>
            </div>
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <div>@include('layouts.partials.alerts._alerts')</div>
            <div class="card-body">
            <div class="form-row changeInputs">
            <div class="form-group{{ $errors->has('make') ? ' has-error' : '' }} col-md-2">
                <label for="make" class="control-label">Make <span class="text-danger">*</span></label>

                        <select class="form-control{{ $errors->has('make') ? ' is-invalid' : '' }} " required="required" id="make" name="make" @if(currentCredits() <= 0) disabled @endif>
                            <option value="" selected="selected">Choose a make</option>
                        </select>

                @if ($errors->has('make'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('make') }}</strong>
                    </div>
                @endif
            </div>



            <div class="form-group{{ $errors->has('model') ? ' has-error' : '' }} col-md-2">
                <label for="model" class="control-label">Model <span class="text-danger">*</span></label>
                <select class="form-control{{ $errors->has('model') ? ' is-invalid' : '' }} " required="required" id="model" name="model" @if(currentCredits() <= 0) disabled @endif>
                    <option value="">Choose a model</option>
                </select>

                @if ($errors->has('model'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('model') }}</strong>
                    </div>
                @endif
            </div>

            <div class="form-group{{ $errors->has('generation') ? ' has-error' : '' }} col-md-2">
                <label for="generation" class="control-label">Generation <span class="text-danger">*</span></label>
                <select class="form-control{{ $errors->has('generation') ? ' is-invalid' : '' }} " required="required" id="generation" name="generation" @if(currentCredits() <= 0) disabled @endif>
                    <option value="">Choose a generation</option>
                </select>

                @if ($errors->has('generation'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('generation') }}</strong>
                    </div>
                @endif
            </div>

            
            <div class="form-group{{ $errors->has('engine') ? ' has-error' : '' }} col-md-2">
                <label for="engine" class="control-label">Engine <span class="text-danger">*</span></label>
                
                <select class="form-control{{ $errors->has('engine') ? ' is-invalid' : '' }} " required="required" id="engine" name="engine" @if(currentCredits() <= 0) disabled @endif>
                    <option value="">Choose a engine</option>
                </select>

                @if ($errors->has('engine'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('engine') }}</strong>
                    </div>
                @endif
            </div>

            <div class="form-group{{ $errors->has('ecu') ? ' has-error' : '' }} col-md-2">
                <label for="ecu" class="control-label">ECU <span class="text-danger">*</span></label>
                <input id="ecu" type="text"
                        class="form-control{{ $errors->has('ecu') ? ' is-invalid' : '' }} "
                        name="ecu"
                        value="{{ old('ecu') }}" required placeholder="Enter ecu" @if(currentCredits() <= 0) disabled @endif>
                @if ($errors->has('ecu'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('ecu') }}</strong>
                    </div>
                @endif
            </div>
        </div>
        <div class="form-row hideLink">
            {{-- <a class="changeToInput" href="#">manual add</a> --}}
                Do the exact specifications of your car not appear in the list above?
                @if(currentCredits() <= 0) 
                
                <a href="#" title="Enter them manually"> Enter them manually</a>
                @else
                <a href="#" title="Enter them manually" class="changeToInput"> Enter them manually</a>
                @endif
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
                <label for="engine_hp" class="control-label">Engine HP <span class="text-danger">*</span></label>

                <input id="engine_hp" type="text"
                        class="form-control{{ $errors->has('engine_hp') ? ' is-invalid' : '' }} "
                        name="engine_hp"
                        value="{{ old('engine_hp') }}"  @if(currentCredits() <= 0) disabled @endif>

                @if ($errors->has('engine_hp'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('engine_hp') }}</strong>
                    </div>
                @endif
            </div>

            <div class="form-group{{ $errors->has('engine_kw') ? ' has-error' : '' }} col-md-6">
                <label for="engine_kw" class="control-label">Engine KW <span class="text-danger">*</span></label>

                <input id="engine_kw" type="text"
                        class="form-control{{ $errors->has('engine_kw') ? ' is-invalid' : '' }} "
                        name="engine_kw"
                        value="{{ old('engine_kw') }}"  @if(currentCredits() <= 0) disabled @endif>

                @if ($errors->has('engine_kw'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('engine_kw') }}</strong>
                    </div>
                @endif
            </div>
            
        </div>

        <div class="form-row">
            <div class="form-group{{ $errors->has('year') ? ' has-error' : '' }} col-md-6">
                <label for="year" class="control-label">Year <span class="text-danger">*</span></label>

                <input id="year" type="text"
                        class="form-control{{ $errors->has('year') ? ' is-invalid' : '' }} "
                        name="year"
                        value="{{ old('year') }}"  @if(currentCredits() <= 0) disabled @endif>

                @if ($errors->has('year'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('year') }}</strong>
                    </div>
                @endif
            </div>

            <div class="form-group{{ $errors->has('gearbox') ? ' has-error' : '' }} col-md-6">
                <label for="gearbox" class="control-label">Gearbox <span class="text-danger">*</span></label>
                
                <select class="form-control{{ $errors->has('gearbox') ? ' is-invalid' : '' }} " required="required" id="gearbox" name="gearbox" @if(currentCredits() <= 0) disabled @endif>
                    <option value="">Choose a gearbox</option>
                    @foreach($gearboxes as $gearboxe)
                    <option value="{{ $gearboxe->id }}">{{ $gearboxe->gbName }}</option>
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
                <label for="license_plate" class="control-label">License Plate <span class="text-danger">*</span></label>

                <input id="license_plate" type="text"
                        class="form-control{{ $errors->has('license_plate') ? ' is-invalid' : '' }} "
                        name="license_plate"
                        value="{{ old('license_plate') }}"  @if(currentCredits() <= 0) disabled @endif>

                @if ($errors->has('license_plate'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('license_plate') }}</strong>
                    </div>
                @endif
            </div>

            <div class="form-group{{ $errors->has('vin') ? ' has-error' : '' }} col-md-6">
                <label for="vin" class="control-label">VIN <span class="text-danger">*</span></label>

                <input id="vin" type="text"
                        class="form-control{{ $errors->has('vin') ? ' is-invalid' : '' }} "
                        name="vin"
                        value="{{ old('vin') }}"  @if(currentCredits() <= 0) disabled @endif>

                @if ($errors->has('vin'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('vin') }}</strong>
                    </div>
                @endif
            </div>
            
        </div>

        <div class="from-row">
            <div class="form-group{{ $errors->has('fuel_octane_rating') ? ' has-error' : '' }}">
                <label for="fuel_octane_rating" class="control-label">Fuel octane rating <span class="text-danger">*</span></label>

                <input id="fuel_octane_rating" type="text"
                        class="form-control{{ $errors->has('fuel_octane_rating') ? ' is-invalid' : '' }} "
                        name="fuel_octane_rating"
                        value="{{ old('fuel_octane_rating') }}"  @if(currentCredits() <= 0) disabled @endif>

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
                <label for="read_method" class="control-label">Read Method <span class="text-danger">*</span></label>
                
                <select class="form-control{{ $errors->has('read_method') ? ' is-invalid' : '' }} " required="required" id="read_method" name="read_method" @if(currentCredits() <= 0) disabled @endif>
                    <option value="">Choose a read method</option>
                    @foreach($readmethods as $readmethod)
                    <option value="{{ $readmethod->id }}">{{ $readmethod->read_method_name }}</option>
                    @endforeach
                </select>

                @if ($errors->has('read_method'))
                    <div class="invalid-feedback">
                        <strong>{{ $errors->first('read_method') }}</strong>
                    </div>
                @endif
            </div>

            <div class="form-group{{ $errors->has('tuning_type') ? ' has-error' : '' }}">
                <label for="tuning_type" class="control-label">Tuning Type <span class="text-danger">*</span></label>
                
            <select class="form-control{{ $errors->has('tuning_type') ? ' is-invalid' : '' }} click" required="required" id="tuning_type" name="tuning_type" @if(currentCredits() <= 0) disabled @endif>
                <option value="">Choose a tuning type</option>
                    @foreach($tuning_types as $tuning_type)
                    <option value="{{ $tuning_type->id }}">{{ $tuning_type->label }} ({{ $tuning_type->credits }})</option>
                    @endforeach
                </select>

                @if ($errors->has('tuning_type'))                                        <div class="invalid-feedback">
                        <strong>{{ $errors->first('tuning_type') }}</strong>
                    </div>
                @endif
            </div>

            <div class="form-row addcheckbox">
                
                
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
                            <input type="file" name="file_to_modify" id="original_file" required class="dropzone" onchange="readURL(this);" @if(currentCredits() <= 0) disabled @endif>
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
                        <label for="timeframe" class="control-label">Timeframe <span class="text-danger">*</span></label>
                        

                        <select class="form-control{{ $errors->has('timeframe') ? ' is-invalid' : '' }} " required="required" id="timeframe" name="timeframe" @if(currentCredits() <= 0) disabled @endif>
                            <option value="" selected="selected">Select a timeframe</option>
                            <option value="ASAP">ASAP</option>
                            <option value="2-3 hours">2-3 hours</option>
                            <option value="5-6 hours">5-6 hours</option>
                        </select>

                        @if ($errors->has('timeframe'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('timeframe') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('dyno') ? ' has-error' : '' }}">
                        <label for="dyno" class="control-label">Dyno</label>
                        
                        <select class="form-control{{ $errors->has('dyno') ? ' is-invalid' : '' }} " required="required" id="dyno" name="dyno" @if(currentCredits() <= 0) disabled @endif>
                            <option value="" selected="selected">Select a dyno</option>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>

                        @if ($errors->has('dyno'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('dyno') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('info') ? ' has-error' : '' }}">
                        <label for="info" class="control-label">Info <span>(optional)</span></label>

                        <textarea id="info" type="text"
                                class="form-control{{ $errors->has('info') ? ' is-invalid' : '' }} "
                                name="info"
                                value="{{ old('info') }}"  @if(currentCredits() <= 0) disabled @endif>{{ old('info') }}</textarea>
                    </div>
                    
                </div>
            </div>
        </div>

        @if( currentCredits() > 0)
        <div class="card">
            
            <div class="card-body">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </div>
        </div>
        @endif
        
    </form>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">

        //  $(document).ready(function () {
        //     $.ajax({
        //         type: "GET",
        //         url: '/makes',
        //          success: function( msg1) { 
        //         // {{-- console.log(msg1); --}}
        //         for (i = 0; i < msg1.length; i++) {

        //                 $('#make').append($('<option>', { 
        //                     value: msg1[i].make_id+'--'+msg1[i].name,
        //                     text : msg1[i].name 
        //                 }));
        //               }
        //          }
        //      });

            
        //   $('#make').on('change', function(){
        //     $.ajax({
        //         type: "GET",
        //         url: '/makes/model/'+$('#make').val().split('--')[0],
        //          success: function( result) { 
        //         console.log(result);

        //         $("#model option").remove();
        //             $('#model').append($('<option>', { 
        //                 value: '',
        //                 text : 'Choose a model'
        //             }));
    
        //             $("#generation option").remove();
        //             $('#generation').append($('<option>', { 
        //                 value: '',
        //                 text : 'Choose a generation'
        //             }));
    
        //             $("#engine option").remove();
        //             $('#engine').append($('<option>', { 
        //                 value: '',
        //                 text : 'Choose an engine'
        //             }));
    
        //             $("#ecu option").remove();
        //             $('#ecu').append($('<option>', { 
        //                 value: '',
        //                 text : 'Choose a ECU'
        //             }));
                    
        //         for (i = 0; i < result.length; i++) {
        //             $('#model').append($('<option>', { 
        //                 value: result[i].name +'--'+ result[i].model_id,
        //                 text : result[i].name 
        //             }));
                        
        //               }
        //          }
        //      });
        // });

        // $('#model').on('change', function(){

        //     $.ajax({
        //         type: "GET",
        //         url: '/model/generation/'+$('#model').val().split('--')[1],
        //          success: function( result) { 
        //         console.log(result);
        //         $("#generation option").remove();
        //         $('#generation').append($('<option>', { 
        //             value: '',
        //             text : 'Choose a generation'
        //         }));

        //         $("#engine option").remove();
        //         $('#engine').append($('<option>', { 
        //             value: '',
        //             text : 'Choose an engine'
        //         }));

        //         $("#ecu option").remove();
        //         $('#ecu').append($('<option>', { 
        //             value: '',
        //             text : 'Choose a ECU'
        //         }));

        //         for (i = 0; i < result.length; i++) {
        //             $('#generation').append($('<option>', { 
        //                 value: result[i].long_name +'--'+ result[i].generation_id,
        //             text : result[i].long_name 
        //             }));
        //               }
        //          }
        //      });

        // });

        // $('#generation').on('change', function(){

        //     $.ajax({
        //         type: "GET",
        //         url: '/generation/engine/' + $('#generation').val().split('--')[1],
        //          success: function( result) { 
        //         console.log(result);
        //         $("#engine option").remove();
        //         $('#engine').append($('<option>', { 
        //             value: '',
        //             text : 'Choose an engine'
        //         }));

        //         $("#ecu option").remove();
        //         $('#ecu').append($('<option>', { 
        //             value: '',
        //             text : 'Choose a ECU'
        //         }));
        //         for (i = 0; i < result.length; i++) {
        //                 $('#engine').append($('<option>', { 
        //                     value: result[i].name +' '+ result[i].power +'hp' + '/' + result[i].engine_id,
        //                     text : result[i].name +' '+ result[i].power +'hp'
        //                 }));
        //               }
        //          }
        //      });

            
        // });
        // }); 
        
    </script>
@stop