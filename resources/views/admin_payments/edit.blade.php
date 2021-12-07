@extends('admin.layouts.default')
@section('admin.breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('admin-payments.index') }}"> Payment getaways</a>
</li>
<li class='breadcrumb-item active'>Edit payment getaway</li>
@endsection

@section('admin.content')
<div class="row">
    <div class="col-md-6">
        <div class="clearfix">
            <div class="card">
                <div class="card-header">
                    <strong>Edit payment getaway</strong> 
                    <span class="center"> </span>
                </div>
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif
                <div class="card-body">
                        <form method="POST" action="{{ route('admin-payments.update', $payment_getaway->id) }}">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                        <div class="form-group{{ $errors->has('payment_name') ? ' has-error' : '' }}">
                            <label class="col-form-label" for="payment_name">Payment name <span class="text-danger">*</span></label>
                                <input type="text" id="payment_name" name="payment_name" class="form-control{{ $errors->has('payment_name') ? ' is-invalid' : '' }} "
                                    placeholder="Enter payment name" required
                                    value="{{ old('payment_name', $payment_getaway->payment_name) }}">
        
                                    @if ($errors->has('payment_name'))
                                        <span class="text-danger">{{ $errors->first('payment_name') }}</span>
                                    @endif
                        </div>
                        <div class="form-group{{ $errors->has('payment_provider') ? ' has-error' : '' }}">
                            <label class="col-form-label" for="payment_provider">Payment provider <span class="text-danger">*</span></label>
                                    <select class="form-control{{ $errors->has('payment_provider') ? ' is-invalid' : '' }} " required="required" id="payment_provider" name="payment_provider" @>
                                        <option value="payfast">PayFast</option>
                                    </select>
        
                                    @if ($errors->has('payment_provider'))
                                        <span class="text-danger">{{ $errors->first('payment_provider') }}</span>
                                    @endif
                        </div>
                        <div class="form-group{{ $errors->has('merchant_id') ? ' has-error' : '' }}">
                            <label class="col-form-label" for="merchant_id">Merchant ID <span class="text-danger">*</span></label>
                                <input type="text" id="merchant_id" name="merchant_id" class="form-control{{ $errors->has('merchant_id') ? ' is-invalid' : '' }} "
                                    placeholder="Enter merchant id" required
                                    value="{{ old('merchant_id', $payment_getaway->merchant_id) }}">
        
                                    @if ($errors->has('merchant_id'))
                                        <span class="text-danger">{{ $errors->first('merchant_id') }}</span>
                                    @endif
                        </div>
                        <div class="form-group{{ $errors->has('merchant_key') ? ' has-error' : '' }}">
                            <label class="col-form-label" for="merchant_key">Merchant key <span class="text-danger">*</span></label>
                                <input type="text" id="merchant_key" name="merchant_key" class="form-control{{ $errors->has('merchant_key') ? ' is-invalid' : '' }} "
                                    placeholder="Enter merchant key" required
                                    value="{{ old('merchant_key', $payment_getaway->merchant_key) }}">
        
                                    @if ($errors->has('merchant_key'))
                                        <span class="text-danger">{{ $errors->first('merchant_key') }}</span>
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