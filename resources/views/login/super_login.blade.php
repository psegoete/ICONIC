<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
  <style>
    
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
        background-image: linear-gradient(180deg,rgba(0,0,0,0.2) 0%,#000000 100%),url({{ asset('logos/MicrosoftTeams-image.png') }})!important;
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
    <div class="row overlay">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 offset-md-3 col-lg-4 offset-lg-4">

                    <div class="container text-dark  justify-content-center " style="border-radius: 10px;background-color:white;">
                    
            <img src="/saas/img/ICD_Logo_PNG_1000px.png" alt="Lamp" height="120" style="display: block; margin-left: auto; margin-right: auto;" align="center" class="pb-3">
                        <h3 class="text-left pb-3 text-center">Login</h3>
                        <div>@include('layouts.partials.alerts._alerts')</div>
                        <form method="POST" action="{{ url('/admin-login') }}" >
                            {{ csrf_field() }}
            
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" placeholder="User name or email *" name="email"
                                value="{{ old('email') }}" required autofocus style=''>
            
                                @if ($errors->has('email'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>
                    
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                id="pwd" placeholder="Password *" name="password" required>
                                @if ($errors->has('password'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-6">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="customCheck"  name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customCheck"> Remember me</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                        <a href="{{ url('password/reset') }}" class="float-right text-right">Forgot password?</a> 
                                </div>

                            </div>
                            <div class="form-group row pb-3">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary pb-2" style="padding:10px;  width:100%; font-weight:500;">Login</button>
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
