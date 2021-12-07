<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot password</title>
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
        /* background-image: linear-gradient(180deg,rgba(0,0,0,0.2) 0%,#000000 100%),url({{ asset('logos/DSCF3035blur.png') }})!important; */
        background-position: center center;
        background-repeat: no-repeat;
        background-size: cover;
        position: absolute;
        min-height: calc(100% - 0px);
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
        height: 45px
      }
    
</style>
</head>
<body>
  @if(checkEagleEyePortal())
        <div class="row overlay" style="background-image: linear-gradient(180deg,rgba(0,0,0,0.2) 0%,#000000 100%),url({{ asset('logos/DSCF3035blur.png') }})!important;
        ">
    @else
        <div class="row overlay" style="background-image: linear-gradient(180deg,rgba(0,0,0,0.2) 0%,#000000  100%),url({{ asset('logos/MicrosoftTeams-image.png') }})!important;
        ">
    @endif
    <div class="col-md-12">
      @if(checkEagleEyePortal())
      <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Lamp" height="110" style="display: block; margin-left: auto; margin-right: auto;" align="center" >
      @endif
      <div class="row">
          <div class="col-md-6 offset-md-3 col-lg-4 offset-lg-4">

              <div class="container text-dark  justify-content-center " style="border-radius: 10px;background-color:white;">
                @if(!checkEagleEyePortal())
                  <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Lamp" height="110" style="display: block; margin-left: auto; margin-right: auto;" align="center" >
                  <h3 class="text-left pb-3 text-center">Forgot password</h3>
                  @else
                  <h3 class="text-left pt-3 pb-3">Forgot password</h3>
                @endif
                              <div>@include('layouts.partials.alerts._alerts')</div>
                        <form method="POST" action="{{ route('password.email') }}">
                                {{ csrf_field() }}
        
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" placeholder="Email *" name="email"
                            value="{{ old('email') }}" required >
        
                            @if ($errors->has('email'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </div>
                            @endif
                        </div>
                        
                        <div class="form-group row">
                          <div class="col-12">
                              <button type="submit" class="btn btn-primary pb-2" style="padding:10px;  width:100%; font-weight:500;">Forgot password</button>
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
