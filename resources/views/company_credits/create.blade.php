@extends('admin.layouts.default')
@section('admin.breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('company-credits.index') }}">Sharing credits</a>
</li>
<li class='breadcrumb-item active'>Create sharing credits</li>
@endsection
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="clearfix">
            <div class="card">
                <div class="card-header">
                    <strong>Create sharing credits</strong> 
                    <span class="center"> </span>
                </div>
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                <div class="card-body">
                    <form action="{{ route('company-credits.store') }}" method="POST" class="form-horizonal">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label class="col-form-label" for="description">Credits <span class="text-danger">*</span></label>
                                    <input type="text" id="description" name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }} "
                                        placeholder="Enter credits" required
                                        value="{{ old('description') }}">
            
                                        @if ($errors->has('description'))
                                            <span class="text-danger">{{ $errors->first('description') }}</span>
                                        @endif
                            </div>

                            <div class="form-group{{ $errors->has('from') ? ' has-error' : '' }}">
                                <label class="col-form-label" for="from">From <span class="text-danger">*</span></label>
                                    <input type="text" id="from" name="from" class="form-control{{ $errors->has('from') ? ' is-invalid' : '' }} "
                                        placeholder="Enter from" required
                                        value="{{ old('from') }}">
            
                                        @if ($errors->has('from'))
                                            <span class="text-danger">{{ $errors->first('from') }}</span>
                                        @endif
                            </div>
                            <div class="form-group{{ $errors->has('for') ? ' has-error' : '' }}">
                                <label class="col-form-label" for="for">For <span class="text-danger">*</span></label>
                                    <input type="text" id="for" name="for" class="form-control{{ $errors->has('for') ? ' is-invalid' : '' }} "
                                        placeholder="Enter for" required
                                        value="{{ old('for') }}">
            
                                        @if ($errors->has('for'))
                                            <span class="text-danger">{{ $errors->first('for') }}</span>
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