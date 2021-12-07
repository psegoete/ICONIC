@extends('layouts.plain')

@section('content')

    <div class="container gid"style="margin-top:200px; " >
        <div class="row  shadow-lg bg-white">
            <div class="col-sm-4 bg-dark" >
                <div class="container  text-white  justify-content-center"><br>
                    <div class="card-body text-center">
                        @if(checkEagleEyePortal())
                            <img src="{{  asset('logos/'.comapnyLogo())}}" alt="Lamp" width="100%" height="100%">
                        @endif
                    </div>
            </div>
        </div>
        <div class="col-sm-8 ml-md-0 ">
            @if(!checkEagleEyePortal())
                <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Lamp" height="110" style="display: block; margin-left: auto; margin-right: auto;" align="center" >
            @endif
            {!! $legalDocument->disclaimer !!}
        </div>
    </div>
@endsection