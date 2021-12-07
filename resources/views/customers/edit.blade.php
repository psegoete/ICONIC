@extends('admin.layouts.default')

@section('admin.breadcrumb')
@if(auth()->user()->role == 'admin')
<li class="breadcrumb-item">
    <a href="{{ route('customers.index') }}">Customers</a>
</li>
@endif
    <li class='breadcrumb-item active'>Editing {{$customer->name}}</li>
@endsection
@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="clearfix">
            <div class="card">
                <div class="card-header">
                    <strong>Editing {{$customer->name}}</strong> 
                    <span class="center"> </span>
                </div>
                <div>@include('layouts.partials.alerts._alerts')</div>
                <div class="card-body">
                    <form action="{{ url('edit-user/'.$customer->id) }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="row">
                            <div class="col-md-6">
                                @if(auth()->user()->role == 'admin' && auth()->user()->id != $customer->id)
                                <div class="form-group{{ $errors->has('credit_group_id') ? ' has-error' : '' }}">
                                    <label for="credit_group_id" class="control-label">Tuning price type</label>
                                    <select class="form-control{{ $errors->has('credit_group_id') ? ' is-invalid' : '' }} " required="required" id="credit_group_id" name="credit_group_id">
                                        @foreach($credit_groups as $credit_group)
                                        <option value="{{ $credit_group->id }}" {{ $credit_group->id  == $customer->credit_group_id ? 'selected="selected"' : '' }}>{{ $credit_group->name}}</option>
                                        @endforeach
                                    </select>
                
                                    @if ($errors->has('credit_group_id'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('credit_group_id') }}</strong>
                                        </div>
                                    @endif
                                </div>
                                @endif
                                <div class="form-group{{ $errors->has('account_type') ? ' has-error' : '' }}">
                                    <label for="account_type" class="control-label">Account type</label>
                                    
                
                                    <select class="form-control{{ $errors->has('account_type') ? ' is-invalid' : '' }} " required="required" id="account_type" name="account_type">
                                        <option value="Business" @if($customer->account_type == 'Business') selected @endif>Business</option>
                                        <option value="Personal" @if($customer->account_type == 'Personal') selected @endif>Personal</option>
                                    </select>
                
                                    @if ($errors->has('account_type'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('account_type') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>
                                    Personal information
                                </h4>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                    <label for="title" class="control-label">Title</label>
                                    
                
                                    <select class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }} " required="required" id="title" name="title">
                                        <option value="">Choose</option>
                                        <option value="Mr." @if($customer->title == 'Mr.') selected @endif>Mr.</option>
                                        <option value="Ms." @if($customer->title == 'Ms.') selected @endif>Ms.</option>
                                    </select>
                
                                    @if ($errors->has('title'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                    <label for="first_name" class="control-label">First Name</label>
                                    
                
                                    <input id="first_name" type="text"
                                    class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                    name="first_name"
                                    value="{{ old('first_name',$customer->first_name ) }}" required>
                
                                    @if ($errors->has('first_name'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                    <label for="last_name" class="control-label">Last Name</label>
                                    
                
                                    <input id="last_name" type="text"
                                    class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                    name="last_name"
                                    value="{{ old('last_name',$customer->last_name) }}" required>
                
                                    @if ($errors->has('last_name'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div> 
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('ticket_display_name') ? ' has-error' : '' }}">
                                    <label for="ticket_display_name" class="control-label">Ticket display name</label>
                                    
                
                                    <input id="ticket_display_name" type="text"
                                    class="form-control{{ $errors->has('ticket_display_name') ? ' is-invalid' : '' }}"
                                    name="ticket_display_name"
                                    value="{{ old('ticket_display_name',$customer->ticket_display_name) }}" required>
                
                                    @if ($errors->has('ticket_display_name'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('ticket_display_name') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div> 
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h4>
                                    Address information
                                </h4>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('address1') ? ' has-error' : '' }}">
                                    <label for="address1" class="control-label">Address 1</label>
                                    
                
                                    <input id="address1" type="text"
                                    class="form-control{{ $errors->has('address1') ? ' is-invalid' : '' }}"
                                    name="address1"
                                    value="{{ old('address1',$customer->address1) }}" required>
                
                                    @if ($errors->has('address1'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('address1') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('address2') ? ' has-error' : '' }}">
                                    <label for="address2" class="control-label">Address 2</label>
                                    
                
                                    <input id="address2" type="text"
                                    class="form-control{{ $errors->has('address2') ? ' is-invalid' : '' }}"
                                    name="address2"
                                    value="{{ old('address2',$customer->address2) }}" required>
                
                                    @if ($errors->has('address2'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('address2') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                    <label for="city" class="control-label">City</label>
                                    
                
                                    <input id="city" type="text"
                                    class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}"
                                    name="city"
                                    value="{{ old('city',$customer->city) }}" required>
                
                                    @if ($errors->has('city'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group{{ $errors->has('zipcode') ? ' has-error' : '' }}">
                                    <label for="zipcode" class="control-label">zipcode</label>
                                    
                
                                    <input id="zipcode" type="text"
                                    class="form-control{{ $errors->has('zipcode') ? ' is-invalid' : '' }}"
                                    name="zipcode"
                                    value="{{ old('zipcode',$customer->zipcode) }}" required>
                
                                    @if ($errors->has('zipcode'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('zipcode') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                    <label for="country" class="control-label">Country</label>
                                    
                                    <select class="form-control{{ $errors->has('country') ? ' is-invalid' : '' }} " required="required" id="country" name="country">
                                        <option value="">Choose country</option>
                                        
                                        @foreach(countries() as $country)
                                        <option value="{{ $country }}" {{ $country  == $customer->country ? 'selected="selected"' : '' }}>{{ $country}}</option>
                                        @endforeach
                                    </select>
                
                                    @if ($errors->has('country'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('country') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group{{ $errors->has('province') ? ' has-error' : '' }}">
                                    <label for="province" class="control-label">State/Province(optional)</label>
                                    
                
                                    <input id="province" type="text"
                                    class="form-control{{ $errors->has('province') ? ' is-invalid' : '' }}"
                                    name="province"
                                    value="{{ old('province',$customer->province) }}" required>
                
                                    @if ($errors->has('province'))
                                        <div class="invalid-feedback">
                                            <strong>{{ $errors->first('province') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h4>
                                    Account information
                                </h4>
                            </div>
                            @if(auth()->user()->id == $customer->id)
                            <div class="col-md-12">
                                <label for="profile_image" class="control-label">Profile image</label>
                                <div class="row">
                                    <div class="col-md-4 col-6">
                                        <div class="dropzone-wrapper1">
                                            <div class="dropzone-desc1">
                                                <div class="exist">
                                                    <p id="empltyoriginalFile1"> No file uploaded yet  </p>
                                                </div>
                                                <div class="notExist">
                                                    <p id="empltyoriginalFile"> No file uploaded yet  </p>
                                                    <p id="originalFile"> </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-6">
                                    <div class="form-group">
                                        
                                        <div class="dropzone-wrapper">
                                        <div class="dropzone-desc">
                                            <i class="fa fa-file"></i>
                                            <p>Drop your file(s) here <br> </p>
                                            <p class="btn btn-secondary clickButton">or click to browse</p>
                                            
                                        </div>
                                        <input type="file" name="profile_image" id="original_file" class="dropzone" onchange="readURL(this);" >
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                                            <label for="phone_number" class="control-label">Phone number</label>
                                            <input id="phone_number" type="text"
                                            class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}"
                                            name="phone_number"
                                            value="{{ old('phone_number',$customer->phone) }}" required>
                        
                                            @if ($errors->has('phone_number'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('phone_number') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label for="email" class="control-label">Email</label>
                                            
                        
                                            <input id="email" type="email"
                                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            name="email"
                                            value="{{ old('email',$customer->email) }}" required>
                        
                                            @if ($errors->has('email'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(auth()->user()->id == $customer->id)
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label for="password" class="control-label">Password</label>
                                            
                        
                                            <input id="password" type="password"
                                            class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                            name="password"
                                            value="{{ old('password') }}">
                        
                                            @if ($errors->has('password'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                            <label for="password_confirmation" class="control-label">Confirm password</label>
                                            
                        
                                            <input id="password_confirmation" type="password"
                                            class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                                            name="password_confirmation"
                                            value="{{ old('password_confirmation') }}">
                        
                                            @if ($errors->has('password_confirmation'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary pb-2" style="padding:10px;  width:100%; font-weight:500;">Save</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection