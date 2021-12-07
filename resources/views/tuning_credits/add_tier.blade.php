@extends('admin.layouts.default')
@section('admin.breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('tuning-credits.index') }}">Tuning credits</a>
</li>
<li class='breadcrumb-item active'>Add credit tier</li>
@endsection
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="clearfix">
            <div class="card">
                <div class="card-header">
                    <strong>Add credit tier</strong> 
                    <span class="center"> </span>
                </div>
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                <div class="card-body">
                    <form action="{{ url('add-tier') }}" method="POST" class="form-horizonal">
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                                <label class="col-form-label" for="amount">Amount <span class="text-danger">*</span></label>
                                    <input type="text" id="amount" name="amount" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }} "
                                        placeholder="Enter credits" required
                                        value="{{ old('amount') }}">
            
                                        @if ($errors->has('amount'))
                                            <span class="text-danger">{{ $errors->first('amount') }}</span>
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
