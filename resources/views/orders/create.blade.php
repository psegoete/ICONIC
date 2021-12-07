@extends('admin.layouts.login')
@section('content')
    <div class="clearfix">
        <div class="card">
            <div class="card-header">
                <strong>Create order</strong> 
                <span class="center"> </span>
            </div>
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <div class="card-body">
                <form method="POST" action="{{ route('orders.store') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('order_no') ? ' has-error' : '' }} row">
                        <label class="col-md-3 col-form-label" for="order_no">Order No</label>
                        <div class="col-md-6">
                            <input type="text" id="order_no" name="order_no" class="form-control{{ $errors->has('order_no') ? ' is-invalid' : '' }} "
                                placeholder="Enter order no" required
                                value="{{ old('order_no') }}">
    
                                @if ($errors->has('order_no'))
                                    <span class="text-danger">{{ $errors->first('order_no') }}</span>
                                @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }} row">
                        <label class="col-md-3 col-form-label" for="description">Description</label>
                        <div class="col-md-6">
                            <input type="text" id="description" name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }} "
                                placeholder="Enter description" required
                                value="{{ old('description') }}">
    
                                @if ($errors->has('description'))
                                    <span class="text-danger">{{ $errors->first('description') }}</span>
                                @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }} row">
                        <label class="col-md-3 col-form-label" for="amount">Amount</label>
                        <div class="col-md-6">
                            <input type="text" id="amount" name="amount" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }} "
                                placeholder="Enter amount" required
                                value="{{ old('amount') }}">
    
                                @if ($errors->has('amount'))
                                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                                @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary" onclick="this.disabled=true;this.form.submit();">
                            Create order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection