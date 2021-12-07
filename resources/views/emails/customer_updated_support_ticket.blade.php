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
                    Dear {{ $data['admin_name'] }}
                </div>
                <div style="padding-top: 10px;padding-bottom: 10px;padding-left: 10px;">
                A <a href="{{ url('/') }}">support ticket </a> has been updated.
                </div>
                <div style="padding-top: 10px;padding-bottom: 5px;padding-left: 10px;">
                    Subject:
                </div>
                <div style="padding-top: 5px;padding-bottom: 10px;padding-left: 10px;">
                    {{ $data['message_subject'] }}
                </div>
                <div style="padding-top: 10px;padding-bottom: 5px;padding-left: 10px;">
                    Message:
                </div>
                <div style="padding-top: 5px;padding-bottom: 10px;padding-left: 10px;">
                    {{ $data['message'] }}
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

<div style="background-color: #e4e5e6; width: 100%; left: 0; right: 0;min-height: 70vh">
    <div style="width: 100%; background-color:#29363d; height:90px" align="center">
        <img src="{{ asset('logos/'.comapnyLogo()) }}" alt="Eagle Eye International" height="80px"> </img>
    </div>
    <div style="margin-left: 5px; margin-right: 5px;margin-top: 25px;">
        <div style="background-color:white;margin-left: 5px; margin-right: 5px;margin-top: 25px;margin-bottom: 25px">
            <p style="margin-left: 6px">
                Dear {{ $data['name'] }}
            </p>
            <p style="margin-left: 6px">
                A <a href="{{ url('/') }}">support ticket </a> has been updated.
            </p>
            <p style="margin-left: 6px">
                Subject:
            </p>
            <p style="margin-left: 6px">
                {{ $data['message_subject'] }}
            </p>
            <p style="margin-left: 6px">
                Message:
            </p>
            <p style="margin-left: 6px">
                {{ $data['message'] }}
            </p>
            <p style="margin-left: 6px">
                Kind regards,
            </p>
            <p style="margin-left: 6px">
               {{ $data['company_name'] }}
            </p>
        </div>
    </div>
    
    <div style="margin-left: 5px; margin-right: 5px;margin-top: 25px;">
        <div style="margin-left: 5px; margin-right: 5px;margin-top: 25px;margin-bottom: 25px">
            <p style="margin-left: 6px">
                <a href="{{ url('/') }}" >Homepage</a> <a href="{{ url('/') }}" >Account</a> <a href="{{ url('/') }}" >Facebook</a> <a href="{{ url('/') }}" >Youtube</a> <a href="{{ url('/') }}" >Instagram</a>
            </p>
        </div>
    </div>
    
    <div style="margin-left: 5px; margin-right: 5px;margin-top: 25px;">
        <div style="margin-left: 5px; margin-right: 5px;margin-top: 25px;margin-bottom: 25px">
            <p style="margin-left: 6px">
                {{ $data['footer'] }}
            </p>
        </div>
    </div>
</div>
</body>
</html>