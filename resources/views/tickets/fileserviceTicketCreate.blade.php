@extends('admin.layouts.default')
@section('title', 'Open Ticket')
@section('admin.breadcrumb')
<li class="breadcrumb-item">
        <a href="{{ route('tickets.index') }}">Tickets</a>
    </li>
<li class='breadcrumb-item '>New ticket</li>
@endsection
@section('content')
<div class="container-fluid mt--6">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h2 class="mb-0"><i class="fas fa-ticket-alt"></i>Start the conversation</h2>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <div>@include('layouts.partials.alerts._alerts')</div>
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/file_services/'. $file_service->id .'/tickets/create') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}
            
                            <div class="form-group row {{ $errors->has('message') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <label for="message" class="col-form-label form-control-label">Message (optional)</label>
                                        <textarea class="form-control" name="message" id="message" cols="20" rows="10">{{ old('message') }}</textarea>
            
                                    @if ($errors->has('message'))
                                        <span class="text-danger">{{ $errors->first('message') }}</span>
                                    @endif
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
                                            <label for="status" class="control-label">Attachment (optional) Only files smaller than 10MB</label>
                                        <div class="row">
                                            <div class="col-md-4 col-6">
                                                <div class="dropzone-wrapper1">
                                                    <div class="dropzone-desc1">
                                                        <div class="existModified">
                                                            <p id="empltymodifiedFile1"> No file uploaded yet  </p>
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
                                                    <p class="btn btn-secondary clickButton ">or click to browse</p>
                                                    
                                                </div>
                                                <input type="file" name="file_name" id="file_name" class="dropzone" onchange="readURLModified(this);" >
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="existFileModified">
                                                <div class="col-md-1 col-1">
                                                    
                                                </div>
                                            </div>
                                            <div class="existFileModified">
                                                <div class="col-md-1 col-1">
        
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
                                </div>
                            </div>

                            <input type="hidden" id="file_service_id" name="file_service_id"value="{{ old('file_service_id', $file_service->id) }}">
            
                            <div class="form-group row">
                                <div class="col-md-6 col-md-offset-6">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-ticket-alt"></i> Open Ticket
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h2 class="mb-0"><i class="fas fa-ticket-alt"></i>File service information</h2>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>No.</strong>
                                <p>{{ $file_service->id }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Tunner</strong>
                                <p>{{ $tunner->first_name }} {{ $tunner->last_name }}</p>
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
                                <strong>Date submitted</strong>
                                <p>{{ $file_service->created_at }}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <strong>Tuning type</strong>
                                <p>{{ $tuning_type->label }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Tuning options</strong>
                                @foreach($tuning_options as $tuning_option)
                                    <div>{{ $tuning_option->label }}</div>
                                @endforeach
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
                                <p>{{ $file_service->license_plate }}</p>
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

                        <div class="row">
                            <div class="col-md-6">
                                <strong>Info</strong>
                                <p>{{ $file_service->info }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Original file</strong>
                                <p>
                                    <a class="" href="{{ URL::to('files/' . $file_service->id) }}" title="Download the original file">Download
                                    </a>
                                </p>
                            </div>
                            @if($file_service->modified)
                                <div class="col-md-6">
                                    <strong>Original file</strong>
                                    <p>
                                        <a class="" href="{{ URL::to('download_modified/' . $file_service->id) }}" title="Download the modified file ">Download
                                        </a>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection