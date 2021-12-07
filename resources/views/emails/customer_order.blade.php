<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template Responsive</title>
    <style type="text/css">
        a {
            color: rgb(62, 204, 251);
        }

        li {
  display: inline-block;
  /* margin: 0 10px; */
}
body{
    /* font-size: 15px; */
}


    </style>
</head>
<body>

{{--  <div style="background-color: #1b16169e; width: 100%; left: 0; right: 0; min-height: 70vh;">
        <div style="width: 100%; background-color:rgb(49 49 49);; height:120px" align="center">
            <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Eagle Eye International" height="100px"> </img>
        </div>
        <div style="margin-left: 5px; margin-right: 5px;margin-top: 25px;">
            <div style="background-color:rgb(16 16 16);margin-left: 5px; margin-right: 5px;margin-top: 25px;margin-bottom: 25px">
                <div style="padding-top: 10px;padding-bottom: 10px;padding-left: 10px;">
                    Dear Mr. Pencox auto-air
                </div>
                <div style="padding-top: 10px;padding-bottom: 10px;padding-left: 10px;">
                An <a href="#">order</a> has been completed.
                </div>
                 <div style="padding-top: 10px;padding-bottom: 5px;padding-left: 10px;">
                    Customer:
                </div>
                <div style="padding-top: 5px;padding-bottom: 10px;padding-left: 10px;">
                    {{ $data['name'] }}
                </div>
                <div style="padding-top: 10px;padding-bottom: 5px;padding-left: 10px;">
                    Total:
                </div>
                <div style="padding-top: 5px;padding-bottom: 10px;padding-left: 10px;">
                    {{ $data['amount'] }}
                </div>
                <div style="padding-top: 10px;padding-bottom: 5px;padding-left: 10px;">
                    Kind regards,
                </div>
                <div style="padding-top: 5px;padding-bottom: 10px;padding-left: 10px;">
                    {{ $data['company_name'] }}
                </div>
            </div>
        </div>
        <div style="padding-top: 10px;margin-bottom: 5px;margin-left: 10px;margin-right: 10px;">
            <div style="display: inline-block;" align="center">
                <a href="{{ url('/') }}" >Homepage</a>
            </div>
            <div style="display: inline-block;" align="center">
                <a href="{{ url('/') }}" >Account</a>
            </div>
            <div style="display: inline-block;" align="center">
                <a href="{{ url('/') }}" >Facebook</a>
            </div>
            <div style="display: inline-block;" align="center">
                <a href="{{ url('/') }}" >Youtube</a>
            </div>
            <div style="display: inline-block;" align="center">
                <a href="{{ url('/') }}" >Instagram</a>
            </div>
        </div>

        <div style="padding-top: 10px;margin-bottom: 5px;margin-left: 10px;margin-right: 10px;">
            {{ $data['footer'] }}
        </div>
</div>  --}}

<div style="background-color: #e4e5e6; width: 100%; left: 0; right: 0;">
    <div style="width: 100%; background-color:#29363d; height:90px" align="center">
        <img src="http://register.iconiccodedevelopment.com/saas/img/ICD_Logo_PNG_1000px.png" alt="Eagle Eye International" height="80px"> </img>
    </div>
    <div style="margin-left: 5px; margin-right: 5px;margin-top: 25px;">

        <div style="background-color:white;margin-left: 5px; margin-right: 5px;margin-top: 25px;margin-bottom: 25px">
        
        <p style="margin-left: 6px">
            Hi {{ $data['company_name']}}
        </p>
        
        <p style="margin-left: 6px">
            Thank you for paying subscription fees for {{ $data['plan']}} plan.
        </p>
        
        @if( $data['credits'] == 1)
        
        <p style="margin-left: 6px">
            Please give the administrator 48 hours (Business days) to prepare your plartform
        </p>
        
        @endif
        
        @if( $data['credits'] == 2)
        
        <p style="margin-left: 6px">
            Please get in touch with your hosting provider to point your portal page to this IP Address: 5.189.174.191
        </p>
        
        <p style="margin-left: 6px">
            Once you are done updating your DNS records, please inform Iconic Code Development at {{$data['iconic_email']}}
        </p>
        
        @endif
        
        @if( $data['credits'] == 3)
        
        <p style="margin-left: 6px">
            Our hosting company will contact you within 2 Business days to help with creating a new domain and have it setup.
        </p>
        
        @endif
        
        <p style="margin-left: 6px">
            Kind regards,
        </p>
        
        <p style="margin-left: 6px">
            Iconic Code Development
        </p>
        
        </div>
        </div>
</div>
</body>
</html>