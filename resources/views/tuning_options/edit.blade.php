@extends('admin.layouts.default')

@section('admin.breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('tuning_types.index') }}"> Tuning types</a>
</li>
<li class='breadcrumb-item active'>{{ $tuning_type->label }}</li>
<li class="breadcrumb-item">
    <a href="{{ URL::to('tuning_types/' . $tuning_type->id . '/tuning_options') }}"> Tuning options</a>
</li>
<li class='breadcrumb-item active'>Create tuning option</li>
@endsection

@section('admin.content')
<div class="row">
    <div class="col-md-6">
        <div class="clearfix">
            <div class="card">
                <div class="card-header">
                    <strong>Edit tuning option</strong> 
                    <span class="center"> </span>
                </div>
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                <div class="card-body">
                            <form method="POST" action="{{ route('tuning_types.tuning_options.update', [$tuning_type->id,$tuning_option->id]) }}" class="form-horizontal">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                            <div class="form-group{{ $errors->has('label') ? ' has-error' : '' }}">
                                <label class="col-form-label" for="label">Label <span class="text-danger">*</span></label>
                                    <input type="text" id="label" name="label" class="form-control{{ $errors->has('label') ? ' is-invalid' : '' }} "
                                        placeholder="Enter label" required
                                        value="{{ old('label', $tuning_option->label) }}">
            
                                        @if ($errors->has('label'))
                                            <span class="text-danger">{{ $errors->first('label') }}</span>
                                        @endif
                            </div>
            
                            <div class="form-group{{ $errors->has('tooltip') ? ' has-error' : '' }}">
                                <label class="col-form-label" for="tooltip">Tooltip <span class="text-danger">*</span></label>
                                    <input type="text" id="tooltip" name="tooltip" class="form-control{{ $errors->has('tooltip') ? ' is-invalid' : '' }}"
                                        placeholder="Enter tooltip" required
                                        value="{{ old('tooltip', $tuning_option->tooltip) }}">
            
                                        @if ($errors->has('tooltip'))
                                            <span class="text-danger">{{ $errors->first('tooltip') }}</span>
                                        @endif
                            </div>
            
                            <div class="form-group{{ $errors->has('credits') ? ' has-error' : '' }}">
                                <label class="col-form-label" for="hf-name">Credits <span class="text-danger">*</span></label>
                                    <input type="text" id="credits" name="credits" class="form-control{{ $errors->has('credits') ? ' is-invalid' : '' }}"
                                        placeholder="Enter credits" required
                                        value="{{ old('credits', $tuning_option->credits) }}">
            
                                        @if ($errors->has('credits'))
                                            <span class="text-danger">{{ $errors->first('credits') }}</span>
                                        @endif
                            </div>
            
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary" onclick="this.disabled=true;this.form.submit();">
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