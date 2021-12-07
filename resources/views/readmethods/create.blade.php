@extends('admin.layouts.default')
@section('admin.breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('readmethods.index') }}"> Read methods</a>
</li>
<li class='breadcrumb-item active'>Create read method</li>
@endsection

@section('admin.content')
<div class="row">
    <div class="col-md-6">
        <div class="clearfix">
            <div class="card">
                <div class="card-header">
                    <strong>Create read method</strong> 
                    <span class="center"> </span>
                </div>
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                <div class="card-body">
                    <form action="{{ route('readmethods.store') }}" method="POST" class="form-horizontal">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('read_method_name') ? ' has-error' : '' }}">
                                <label class="col-form-label" for="read_method_name">Name <span class="text-danger">*</span></label>
                                    <input type="text" id="read_method_name" name="read_method_name" class="form-control{{ $errors->has('read_method_name') ? ' is-invalid' : '' }} "
                                        placeholder="Enter name" required
                                        value="{{ old('read_method_name') }}">
            
                                        @if ($errors->has('read_method_name'))
                                            <span class="text-danger">{{ $errors->first('read_method_name') }}</span>
                                        @endif
                            </div>
            
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    Save
                                </button>
                            </div>
                    </form>
                </div>
                {{-- <div class="card-footer">
                    <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reset</button>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection