{{--  @extends('account.layouts.default')  --}}
@extends('admin.layouts.default1')
@section('admin.breadcrumb')
<li class='breadcrumb-item active'>File service</li>
@endsection
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="container">
            <div class="card">
                <div class="card-header">
                        <span class="title"><i class="fas fa-comment-dots"></i>Process the file service</span>
                </div>
                <div class="card-body">
                    <div class="comment-form">
                        <div>@include('layouts.partials.alerts._alerts')</div>
                        <form method="POST" action="{{ route('file_services.update', $file_service->id) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            
                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }} row">
                                <div class="col-md-12">
                                    <label for="status" class="control-label">Status</label>
                                    <select class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }} " required="required" id="status" name="status">
                                        <option value="Open" @if($file_service->status == 'Open') selected @endif>Open</option>
                                        <option value="Waiting" @if($file_service->status == 'Waiting') selected @endif>Waiting</option>
                                        <option value="Completed" @if($file_service->status == 'Completed') selected @endif>Completed</option>
                                    </select>
            
                                    @if ($errors->has('status'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </div>
                                    @endif
    
                                </div>
                                
                            </div>
    
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="status" class="control-label">Original file</label>
                                <div class="row">
                                    <div class="col-md-4 col-6">
                                        <div class="dropzone-wrapper1">
                                            <div class="dropzone-desc1">
                                                <div class="exist">
                                                    @if($file_service->file_to_modify)
                                                    <p id="originalFileExist"> <i class="fa fa-file"></i> <br> {{ $file_service->file_to_modify_title }} </p>
                                                    @else
                                                    <p id="empltyoriginalFile"> No file uploaded yet  </p>
                                                    @endif
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
                                            <i class="fa fa-download"></i>
                                            <p>Drop your file(s) here <br> </p>
                                            <p class="btn btn-secondary clickButton">or click to browse</p>
                                            
                                        </div>
                                        <input type="file" name="original_file" id="original_file" class="dropzone" onchange="readURL(this);" >
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="existFile">
                                        <div class="col-md-1 col-1">
                                            @if($file_service->file_to_modify)
                                            <p><a class="" href="{{ URL::to('files/' . $file_service->id) }}" title="Download the original file for this file service"><i class="fa fa-download"></i>
                                            </a></p>
                                            @else
                                            
                                            @endif
                                        </div>
                                    </div>
                                    <div class="existFile">
                                        <div class="col-md-1 col-1">
                                            @if($file_service->file_to_modify)
                                            <p><a class="" href="#" onclick="removeUpload();"><i class="fa fa-trash"></i>
                                            </a></p>
                                            @else
                                            @endif

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

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="status" class="control-label">Modified file (optional)</label>
                                <div class="row">
                                    <div class="col-md-4 col-6">
                                        <div class="dropzone-wrapper1">
                                            <div class="dropzone-desc1">
                                                <div class="existModified">
                                                    @if($file_service->modified)
                                                    <p id="modifiedFileExist"> <i class="fa fa-file"></i> <br> {{ $file_service->modified_title }} </p>
                                                    @else
                                                    <p id="empltymodifiedFile1"> No file uploaded yet  </p>
                                                    @endif
                                                </div>
                                                <div class="notExistModified">
                                                    <p id="empltymodifiedFile"> No file uploaded yet  </p>
                                                    <p id="modifiedFile"> </p>
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
                                        <input type="file" name="modified_file" id="modified_file" class="dropzone" onchange="readURLModified(this);" >
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="existFileModified">
                                        <div class="col-md-1 col-1">
                                            @if($file_service->modified)
                                            <p><a class="" href="{{ URL::to('download_modified/' . $file_service->id) }}" title="Download the original file for this file service"><i class="fa fa-download"></i>
                                            </a></p>
                                            @else
                                            
                                            @endif
                                        </div>
                                    </div>
                                    <div class="existFileModified">
                                        <div class="col-md-1 col-1">
                                            @if($file_service->modified)
                                            <p><a class="" href="#" onclick="removeUploadModified();"><i class="fa fa-trash"></i>
                                            </a></p>
                                            @else
                                            @endif

                                        </div>
                                    </div>
                        
                                    <div class="notExistFileModified">
                                        <div class="col-md-1 col-1 importModified">
                                        </div>
                                    </div>
                                    <div class="notExistFileModified ">
                                        <div class="col-md-1 col-1 deleteModifiedFile">
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
    
                            <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }} row">
                                <div class="col-md-12">
                                    <label for="notes" class="col-form-label form-control-label">Message</label>
                                    <textarea rows="4" id="notes" class="form-control" name="notes">{{ old('notes',$file_service->notes) }}</textarea>
                
                                    @if ($errors->has('notes'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('notes') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="status" class="control-label">Dynograph file (optional)</label>
                                <div class="row">
                                    <div class="col-md-4 col-6">
                                        <div class="dropzone-wrapper1">
                                            <div class="dropzone-desc1">
                                                <div class="existDynograph">
                                                    @if($file_service->dynograph)
                                                    <p id="dynographFileExist"> <i class="fa fa-file"></i> <br> {{ $file_service->dynograph_title }} </p>
                                                    @else
                                                    <p id="empltydynographFile1"> No file uploaded yet  </p>
                                                    @endif
                                                </div>
                                                <div class="notExistDynograph">
                                                    <p id="empltydynographFile"> No file uploaded yet  </p>
                                                    <p id="dynographFile"> </p>
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
                                        <input type="file" name="dynograph_file" id="dynograph_file" class="dropzone" onchange="readURLDynograph(this);" >
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="existFileDynograph">
                                        <div class="col-md-1 col-1">
                                            @if($file_service->dynograph)
                                            <p><a class="" href="{{ URL::to('download_dynograph/' . $file_service->id) }}" title="Download the original file for this file service"><i class="fa fa-download"></i>
                                            </a></p>
                                            @else
                                            
                                            @endif
                                        </div>
                                    </div>
                                    <div class="existFileDynograph">
                                        <div class="col-md-1 col-1">
                                            @if($file_service->dynograph)
                                            <p><a class="" href="#" onclick="removeUploadDynograph();"><i class="fa fa-trash"></i>
                                            </a></p>
                                            @else
                                            @endif

                                        </div>
                                    </div>
                        
                                    <div class="notExistFileDynograph">
                                        <div class="col-md-1 col-1 importDynograph">
                                        </div>
                                    </div>
                                    <div class="notExistFileDynograph ">
                                        <div class="col-md-1 col-1 deleteDynographFile">
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            
    
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="container">
            <center>
            </center>
            <div class="accordion" id="fileServiceInformation">
                <div class="card">
                    <div class="card-header" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true">     
                        <span class="title">File service information</span>
                        <span class="accicon"><i class="fa fa-angle-up rotate-icon"></i></span>
                    </div>
                    <div id="collapseOne" class="collapse show" data-parent="#fileServiceInformation">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>No.</strong>
                                    <p>{{ $file_service->id }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>Date submitted</strong>
                                    <p>{{ $file_service->created_at }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Car</strong>
                                    <p>{{ $file_service->model }}  {{ $file_service->make }}  {{ $file_service->engine }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>ECU</strong>
                                    <p>{{ $file_service->ecu }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Tunner</strong>
                                    <p>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Credits</strong>
                                    <p>{{ $file_service->credits }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Tuning type</strong>
                                    @if($tuning_type->label)
                                    <p>{{ $tuning_type->label }}</p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <strong>Tuning options</strong>
                                    @if($tuning_options->count())
                                    @foreach($tuning_options as $tuning_option)
                                        <div>{{ $tuning_option->label }}</div>
                                    @endforeach
                                    @else
                                    <p>
                                        No additional options selected
                                    </p>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Timeframe</strong>
                                    <p>{{ $file_service->timeframe }}</p>
                                </div>
                                <div class="col-md-6">
                                    <strong>On Dynos?</strong>
                                    @if($file_service->dyno == 1)
                                    <p>Yes</p>
                                    @else
                                    <p>No</p>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Info</strong>
                                    <p>{{ $file_service->info }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Original file</strong>
                                    @if($file_service->file_to_modify)
                                    <p><a class="" href="{{ URL::to('files/' . $file_service->id) }}" title="Download the original file for this file service">Download
                                    </a></p>
                                    @endif
                                </div>
                            
                                <div class="col-md-6">
                                    <strong>Modified file</strong>
                                    @if($file_service->modified)
                                    <p><a class="" href="{{ URL::to('download_modified/' . $file_service->id) }}" title="Download the modified file for this file service">Download
                                    </a></p>
                                    @endif
                                </div>
                            </div>
                         </div>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="container">
            <center>
            </center>
            <div class="accordion" id="customerInformation">
                <div class="card">
                    <div class="card-header" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">     
                        <span class="title">Customer information</span>
                        <span class="accicon"><i class="fa fa-angle-up rotate-icon"></i></span>
                    </div>
                    <div id="collapseTwo" class="collapse show" data-parent="#customerInformation">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>{{ $customer->first_name }}</strong>
                                    <p>{{ $customer->first_name }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Name</strong>
                                    <p>{{ $customer->first_name }} {{ $customer->last_name }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Email</strong>
                                    <p>{{ $customer->email }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Phone</strong>
                                    <p>{{ $customer->phone }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Country</strong>
                                    <p>{{ $customer->country }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        <div class="container">
            <center>
            </center>
            <div class="accordion" id="additionalInformation">
                <div class="card">
                    <div class="card-header" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">     
                        <span class="title">Additional information</span>
                        <span class="accicon"><i class="fa fa-angle-up rotate-icon"></i></span>
                    </div>
                    <div id="collapseThree" class="collapse show" data-parent="#additionalInformation">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Year</strong>
                                    <p>{{ $file_service->year }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Gearbox</strong>
                                    <p>{{ $gearbox->gbName }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Read method</strong>
                                    <p>{{ $readmethod->read_method_name }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>License plate</strong>
                                    <p>{{ $readmethod->license_plate }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>VIN</strong>
                                    <p>{{ $file_service->vin }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Fuel octane rating</strong>
                                    <p>{{ $file_service->fuel_octane_rating }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection