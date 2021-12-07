@extends('admin.layouts.default')

@section('admin.breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('tuning_types.index') }}"> Tuning types</a>
</li>
<li class='breadcrumb-item active'>Create tuning type</li>
@endsection


@section('admin.content')
<div class="row">
    <div class="col-md-6">
        <div class="clearfix">
            <div class="card">
                <div class="card-header">
                    <strong>Create tuning type</strong> 
                    <span class="center"> </span>
                </div>
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                <div class="card-body">
                    <form action="{{ route('tuning_types.store') }}" method="POST" class="form-horizontal">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('label') ? ' has-error' : '' }}">
                                <label class="col-form-label" for="label">Label <span class="text-danger">*</span></label>
                                    <input type="text" id="label" name="label" class="form-control{{ $errors->has('label') ? ' is-invalid' : '' }} "
                                        placeholder="Enter label" required
                                        value="{{ old('label') }}">
            
                                        @if ($errors->has('label'))
                                            <span class="text-danger">{{ $errors->first('label') }}</span>
                                        @endif
                            </div>
            
                            <div class="form-group{{ $errors->has('credits') ? ' has-error' : '' }}">
                                <label class="col-form-label" for="hf-name">Credits <span class="text-danger">*</span></label>
                                    <input type="text" id="credits" name="credits" class="form-control{{ $errors->has('credits') ? ' is-invalid' : '' }}"
                                        placeholder="Enter credits" required
                                        value="{{ old('credits') }}">
            
                                        @if ($errors->has('credits'))
                                            <span class="text-danger">{{ $errors->first('credits') }}</span>
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