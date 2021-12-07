{{--  @extends('layouts.plain')

@section('content')

    <div class="container gid"style="margin-top:200px; " >
        <div class="row  shadow-lg bg-white">
            <div class="col-sm-4 bg-dark" >
                <div class="container  text-white  justify-content-center"><br>
                    <div class="card-body text-center">
                        <img src="{{  asset('logos/'.comapnyLogo())}}" alt="Lamp" width="100%" height="100%">
                    </div>
            </div>
        </div>
        <div class="col-sm-8 ml-md-0 " style="margin-top:20px; ">
            {!! $legalDocument->privancy_policy !!}
        </div>
    </div>
@endsection  --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>privacy-policy</title>
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
                    <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-3">
    
                        <div class="container text-dark  justify-content-center pt-4 pb-4" style="border-radius: 10px;background-color:white;">
                            @if(!checkEagleEyePortal())
                                <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Lamp" height="110" style="display: block; margin-left: auto; margin-right: auto;" align="center" >
                            @endif
                            {!! $legalDocument->privancy_policy !!}
                        </div>
                    </div>
                </div>
                
              </div>
        </div>
</body>
</html>

