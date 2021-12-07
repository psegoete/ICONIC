@extends('admin.layouts.default')

@section('admin.breadcrumb')
<li class='breadcrumb-item active'>Update profile</li>
@endsection

@section('admin.content')
<div class="clearfix">
    <div class="card">
        <div class="card-header">
            <strong>Update profile</strong>
        </div>
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <div class="card-body">
            <form action="{{ route('profile.update', $user->id) }}" method="POST" class="form-horizontal offset-sm-2" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    @method('PUT')
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">First Name</label>
                    <div class="col-md-6">
                        <input type="text" id="first_name" name="first_name" class="form-control" value="{{ $user->first_name }}"
                            required>

                            @if ($errors->has('first_name'))
                                <span class="text-danger">{{ $errors->first('first_name') }}</span>
                            @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Last name</label>
                    <div class="col-md-6">
                        <input type="text" id="last_name" name="last_name" class="form-control"
                            value="{{ $user->last_name }}" required>

                            @if ($errors->has('last_name'))
                                <span class="text-danger">{{ $errors->first('last_name') }}</span>
                            @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Ticket display name</label>
                    <div class="col-md-6">
                        <input type="text" id="ticket_display_name" name="ticket_display_name" class="form-control"
                            value="{{ $user->ticket_display_name }}" required>

                            @if ($errors->has('ticket_display_name'))
                                <span class="text-danger">{{ $errors->first('ticket_display_name') }}</span>
                            @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Email</label>
                    <div class="col-md-6">
                        <input type="text" id="trial" name="email" class="form-control"
                            value="{{ $user->email }}" required>

                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Phone</label>
                    <div class="col-md-6">
                        <input type="text" id="trial" name="phone" class="form-control"
                            value="{{ $user->phone }}" required>

                            @if ($errors->has('phone'))
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                            @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Password</label>
                    <div class="col-md-6">
                        <input type="password" id="password" name="password" class="form-control"
                             >

                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name"></label>
                    <div class="col-md-6">
                        {{--  <label for="status" class="control-label">Attachment (optional)
                          Only files smaller than 10MB</label>  --}}
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
                            <input type="file" name="profile_image" id="original_file" class="dropzone" onchange="readURL(this);" >
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
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Update</button>
            </form>
        </div>
        <div class="card-footer">
            <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reset</button>
        </div>
    </div>
</div>
@endsection