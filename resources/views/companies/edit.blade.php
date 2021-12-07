@extends('admin.layouts.default')
@section('admin.breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('companies.index') }}">Companies</a>
</li>
<li class='breadcrumb-item active'>Edit {{ $company->company_name }}</li>

@endsection
@section('content')
     <div class="row">
        <div class="col-md-6">
            <div class="clearfix">
                <div class="card">
                    <div class="card-header">
                        <strong>Edit company</strong> 
                        <span class="center"> </span>
                    </div>
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="card-body">
                                <form method="POST" action="{{ route('companies.update', $company->id)  }}" class="form-horizontal">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                <div class="form-group{{ $errors->has('domain_name') ? ' has-error' : '' }}">
                                    <label class="col-form-domain_name" for="domain_name">Domain name</label>
                                        <input type="text" id="domain_name" name="domain_name" class="form-control{{ $errors->has('domain_name') ? ' is-invalid' : '' }} "
                                            placeholder="Enter domain_name" required
                                            value="{{ old('domain_name', $company->domain_name) }}">
                
                                            @if ($errors->has('domain_name'))
                                                <span class="text-danger">{{ $errors->first('domain_name') }}</span>
                                            @endif
                                </div>

                                <div class="form-group{{ $errors->has('plan') ? ' has-error' : '' }}">
                                    <label class="col-form-active" for="plan">Plan</label>
                                    <select class="form-control{{ $errors->has('plan') ? ' is-invalid' : '' }} " required="required" id="dyno" name="plan" >
                                        <option value="849" @if($company->plan == 'basic') selected @endif>Basic</option>
                                        <option value="1350" @if($company->plan == 'standard') selected @endif>Advanced</option>
                                        <option value="2399" @if($company->plan == 'enterprice') selected @endif>Ultimate</option>
                                    </select>
                
                                    @if ($errors->has('plan'))
                                        <span class="text-danger">{{ $errors->first('plan') }}</span>
                                    @endif
                                </div>

                                @if($company->active == 0)
                                <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
                                    <label class="col-form-active" for="active">Active status</label>
                                    <select class="form-control{{ $errors->has('dyno') ? ' is-invalid' : '' }} " required="required" id="dyno" name="active" >
                                        <option value="0" @if($company->active == 0) selected @endif>No</option>
                                        <option value="1" @if($company->active == 1) selected @endif>Yes</option>
                                    </select>
                
                                    @if ($errors->has('active'))
                                        <span class="text-danger">{{ $errors->first('active') }}</span>
                                    @endif
                                </div>
                                @else
                                {{-- <input type="hidden" value="1" name="active"> --}}
                                @if ($status == 'false')
                                <div class="form-group"> 
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck"  name="subscribe">
                                        <label class="custom-control-label" for="customCheck">Subscribe</label>
                                    </div>
                                </div>
                                @endif
                                @endif
                
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