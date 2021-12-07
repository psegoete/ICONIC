@extends('admin.layouts.default')

@section('admin.breadcrumb')
<li class='breadcrumb-item active'> Delivery times</li>
@endsection

@section('admin.content')
<div class="row">
    <div class="col-md-6">
        <div class="clearfix">
            <div class="card">
                <div class="card-header">
                    <strong> Delivery times</strong> 
                    <span class="center"> </span>
                </div>
                <div class="card-body">
                  <div class="row pb-2">
                    <div class="col-md-12">
                      All times are in minutes.
                    </div>
                    <div class="col-md-12">
                      Leave these fields blank if you do not want to display estimated delivery times for file services.
                    </div>
                  </div>
                    <form action="{{ url('updateDeliveryTime') }}" method="POST" class="form-horizontal">
                      {{ csrf_field() }}
                      {{ method_field('PUT') }}
                            <div class="form-group{{ $errors->has('minimum_time') ? ' has-error' : '' }}">
                                <label class="col-form-label" for="minimum_time">Minimum time </label>
                                    <input type="text" id="minimum_time" name="minimum_time" class="form-control{{ $errors->has('minimum_time') ? ' is-invalid' : '' }} "
                                        placeholder="Minimum time" 
                                        value="{{ old('minimum_time',$deliveryTime->minimum_time) }}">
            
                                        @if ($errors->has('minimum_time'))
                                            <span class="text-danger">{{ $errors->first('minimum_time') }}</span>
                                        @endif
                            </div>
                            <div class="form-group{{ $errors->has('maximum_time') ? ' has-error' : '' }}">
                                <label class="col-form-label" for="maximum_time">Maximum time </label>
                                    <input type="text" id="maximum_time" name="maximum_time" class="form-control{{ $errors->has('maximum_time') ? ' is-invalid' : '' }} "
                                        placeholder="Maximum time"
                                        value="{{ old('maximum_time',$deliveryTime->maximum_time) }}">
            
                                        @if ($errors->has('maximum_time'))
                                            <span class="text-danger">{{ $errors->first('maximum_time') }}</span>
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