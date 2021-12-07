@extends('account.layouts.default')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-8 offset-sm-2">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Create new gearboxe</h4>

                        <form method="POST" action="{{ route('packages.store') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('package_name') ? ' has-error' : '' }}">
                                <label for="package_name" class="control-label">Package Name</label>

                                <input id="package_name" type="text"
                                       class="form-control{{ $errors->has('package_name') ? ' is-invalid' : '' }}"
                                       name="package_name"
                                       value="{{ old('package_name') }}"  autofocus>

                                @if ($errors->has('package_name'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('package_name') }}</strong>
                                    </div>
                                @endif
                            </div>

                             <div class="form-group{{ $errors->has('package_description') ? ' has-error' : '' }}">
                                <label for="package_description" class="control-label">Package Description</label>

                                <input id="package_description" type="text"
                                       class="form-control{{ $errors->has('package_description') ? ' is-invalid' : '' }}"
                                       name="package_description"
                                       value="{{ old('package_description') }}" required autofocus>

                                @if ($errors->has('package_description'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('package_description') }}</strong>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                <label for="price" class="control-label">Price</label>

                                <input id="price" type="text"
                                       class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}"
                                       name="price"
                                       value="{{ old('price') }}" required autofocus>

                                @if ($errors->has('price'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </div>
                                @endif
                            </div> 

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" onclick="this.disabled=true;this.form.submit();">
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