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
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        <div class="row">
            <div class="col-md-6">

                <div class="card">
                    <!-- Card header -->
                    <div class="card-header">
                        <h2 class="mb-0"><i class="fas fa-ticket-alt"></i> New ticket</h2>
                    </div>
                    <!-- Card body -->
                    <div class="card-body">
                            
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}

                            <input type="hidden" id="file_service_id" name="file_service_id"value="{{ old('file_service_id', $file_service->id) }}">
                            <input type="hidden" id="category_id" name="category_id"value="{{ old('category_id', $category_id) }}">


                            <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                                <label for="message" class="control-label">Message</label>
        
                                <textarea id="message"
                                        class="form-control{{ $errors->has('message') ? ' is-invalid' : '' }} "
                                        name="message" >{{ old('message') }}</textarea>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="status" class="control-label">Attachment (optional)
                                      Only files smaller than 10MB</label>
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
                                        <input type="file" name="file_name" id="file_name" class="dropzone" onchange="readURL(this);" >
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

                            {{--  <div class="form-group">
                                <div class="file-upload">
                                    <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )">Add file</button>
                                  
                                    <div class="image-upload-wrap">
                                      <input class="file-upload-input{{ $errors->has('file_to_modify') ? ' is-invalid' : '' }}" type='file' name="file_to_modify" onchange="readURL(this);" />
                                      <div class="drag-text">
                                        <h3>Drag and drop a file or select add file</h3>
                                      </div>
                                    </div>
                                    <div class="file-upload-content">
                                      <img class="file-upload-image" src="#" alt="your image" />
                                      <div class="image-title-wrap">
                                        <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded file</span></button>
                                      </div>
                                    </div>
                                  </div>
                            </div>  --}}
            
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
                
            </div>
        </div>
</div>
@endsection