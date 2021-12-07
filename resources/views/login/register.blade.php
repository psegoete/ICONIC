<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
  <style>
    .phpdebugbar{
        display: none;
      }
    .pb-7, .py-7 {
        padding-bottom: 1.75rem!important;
    }
    .pt-7, .py-7 {
        padding-top: 1.75rem!important;
    }
    p span {
        display: block;
      }

      .overlay{
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        position: absolute;
        min-height: calc(100% - 100px);
        display: flex;
        place-items: center;
        margin-right: 0px;
        margin-left: 0px;
        right: 0px;
        left: 0px;
      }

      .form-control{
        background: #f3f6f9; 
        border-radius: 0.4em; 
        {{--  height: 45px  --}}
      }
    
</style>
</head>
<body>
    {{--  <div class="overlay"></div>  --}}
    @if(checkEagleEyePortal())
    <div class="row overlay" style="background-image: linear-gradient(180deg,rgba(0,0,0,0.2) 0%,#000000 100%),url({{ asset('logos/DSCF3035blur.png') }})!important;
    ">
@else
    <div class="row overlay" style="background-image: linear-gradient(180deg,rgba(0,0,0,0.2) 0%,#000000  100%),url({{ asset('logos/MicrosoftTeams-image.png') }})!important;padding-top: 100px;">
@endif
            
            <div class="col-md-12">
                @if(checkEagleEyePortal())
                <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Lamp" height="110" style="display: block; margin-left: auto; margin-right: auto;" align="center" >
                @endif
                <div class="row">
                    <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
    
                        <div class="container text-dark  justify-content-center pt-1" style="border-radius: 10px;background-color:white;">
                            @if(!checkEagleEyePortal())
                            <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Lamp" height="110" style="display: block; margin-left: auto; margin-right: auto;" align="center" >
                            <h3 class="text-left pt-3 pb-1 text-center">Register</h3>
                            @else
                            <h3 class="text-left pt-3 pb-3">Register</h3>
                            @endif
                                        <div>@include('layouts.partials.alerts._alerts')</div>
                                        <form action="{{ route('register') }}" method="post">
                                            {{ csrf_field() }}
                  
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('account_type') ? ' has-error' : '' }}">
                                            <label for="account_type" class="control-label">Account type</label>
                                            
                        
                                            <select class="form-control{{ $errors->has('account_type') ? ' is-invalid' : '' }} " required="required" id="account_type" name="account_type">
                                                <option value="Business">Business</option>
                                                <option value="Personal">Personal</option>
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
                                            <label for="title" class="control-label">Account type</label>
                                            
                        
                                            <select class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }} " required="required" id="title" name="title">
                                                <option value="">Choose</option>
                                                <option value="Mr.">Mr.</option>
                                                <option value="Ms.">Ms.</option>
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
                                               value="{{ old('first_name') }}" required>
                        
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
                                               value="{{ old('last_name') }}" required>
                        
                                            @if ($errors->has('last_name'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('last_name') }}</strong>
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
                                               value="{{ old('address1') }}" required>
                        
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
                                               value="{{ old('address2') }}" required>
                        
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
                                               value="{{ old('city') }}" required>
                        
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
                                               value="{{ old('zipcode') }}" required>
                        
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
                                                <option value="{{ $country }}">{{ $country}}</option>
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
                                               value="{{ old('province') }}" required>
                        
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
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
                                                    <label for="phone_number" class="control-label">Phone number</label>
                                                    <input id="phone_number" type="text"
                                                       class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}"
                                                       name="phone_number"
                                                       value="{{ old('phone_number') }}" required>
                                
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
                                                       value="{{ old('email') }}" required>
                                
                                                    @if ($errors->has('email'))
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                                    <label for="password" class="control-label">Password</label>
                                                    
                                
                                                    <input id="password" type="password"
                                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                       name="password"
                                                       value="{{ old('password') }}" required>
                                
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
                                                       value="{{ old('password_confirmation') }}" required>
                                
                                                    @if ($errors->has('password_confirmation'))
                                                        <div class="invalid-feedback">
                                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                
                                
                                  <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input{{ $errors->has('terms_and_conditions') ? ' is-invalid' : '' }}" id="terms_and_conditions"  name="terms_and_conditions" {{ old('terms_and_conditions') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="terms_and_conditions"> I have read and agree to the <a href="{{ url('terms-and-conditions') }}">Terms and conditions </a></label>
                                            @if ($errors->has('terms_and_conditions'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('terms_and_conditions') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                      </div>
                                  </div>
                                  <div class="form-group row">
                                    <div class="col-md-12">

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input{{ $errors->has('privacy_policy') ? ' is-invalid' : '' }}" id="privacy_policy"  name="privacy_policy" {{ old('privacy_policy') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="privacy_policy">I have read and agree to the <a href="{{ url('privacy-policy') }}">Privacy policy </a></label>
                                            @if ($errors->has('privacy_policy'))
                                                <div class="invalid-feedback">
                                                    <strong>{{ $errors->first('privacy_policy') }}</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary pb-2" style="padding:10px;  width:100%; font-weight:500;">Register</button>
                                    </div>
                                  </div>
    
                                <div class="form-group row">
                                    <div class="col-12">
                                        <p><span>Already a member?</span><span><a href="{{ url('/') }}">Login</a></span></p>
                                    </div>
                                </div>
    
                          </form>
                        </div>
                    </div>
                </div>
                
              </div>
        </div>
</body>
</html>