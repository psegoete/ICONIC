@extends('admin.layouts.default')

@section('admin.breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('gearboxes.index') }}"> Gearboxes</a>
</li>
<li class='breadcrumb-item active'>Edit gearbox</li>
@endsection

@section('admin.content')
<div class="row">
    <div class="col-md-6">
        <div class="clearfix">
            <div class="card">
                <div class="card-header">
                    <strong>Edit gearbox</strong> 
                    <span class="center"> </span>
                </div>
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                <div class="card-body">
                    <form method="POST" action="{{ route('gearboxes.update', $gearbox->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                            <div class="form-group{{ $errors->has('gbName') ? ' has-error' : '' }} ">
                                <label class="col-form-label" for="gbName">Name <span class="text-danger">*</span></label>
                                    <input type="text" id="gbName" name="gbName" class="form-control{{ $errors->has('gbName') ? ' is-invalid' : '' }} "
                                        placeholder="Enter name" required
                                        value="{{ old('gbName',$gearbox->gbName) }}">
            
                                        @if ($errors->has('gbName'))
                                            <span class="text-danger">{{ $errors->first('gbName') }}</span>
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