@extends('admin.layouts.default')

@section('admin.breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ url('mail-templates') }}"> Mail templates</a>
</li>
<li class='breadcrumb-item active'>{{ $mail->name }}</li>
@endsection

@section('admin.content')
<div class="row">
    <div class="col-md-6">
        <div class="clearfix">
            <div class="card">
                <div class="card-header">
                    <strong>{{ $mail->name }}</strong> 
                    <span class="center"> </span>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ url('mails/'. $mail->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} ">
                                <label class="col-form-label" for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }} "
                                        placeholder="Enter name" required
                                        value="{{ old('name',$mail->name) }}">
            
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                            </div>
                            <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }} ">
                                <label class="col-form-label" for="subject">Subject <span class="text-danger">*</span></label>
                                    <input type="text" id="subject" name="subject" class="form-control{{ $errors->has('subject') ? ' is-invalid' : '' }} "
                                        placeholder="Enter subject" required
                                        value="{{ old('subject',$mail->subject) }}">
            
                                        @if ($errors->has('subject'))
                                            <span class="text-danger">{{ $errors->first('subject') }}</span>
                                        @endif
                            </div>

                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }} ">
                                <label for="body">Body</label>
                                <textarea name="body" id="body" cols="30" rows="10" class="form-control{{ $errors->has('body') ? ' is-invalid' : '' }} summernote">{{ old('body', $mail->body) }}</textarea>
                                
                                @if ($errors->has('body'))
                                    <span class="text-danger">{{ $errors->first('body') }}</span>
                                @endif
                            </div>
            
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    Save
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection