<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>password</title>
</head>
<body>
<div style="background-color: #e4e5e6; width: 100%; left: 0; right: 0;">
    <div style="width: 100%; background-color:#29363d; height:90px" align="center">
        <img src="http://portal.eagletunedinternational.com/logos/wqTnl7Wi7QaxBOl7JOMVwWgq1Rzr78T8NHYMl1KW.png" alt="Eagle Eye International" height="80px"> </img>
    </div>
    <div style="margin-left: 5px; margin-right: 5px;margin-top: 25px;">
        <div style="background-color:white;margin-left: 5px; margin-right: 5px;margin-top: 25px;margin-bottom: 25px">
            <p style="margin-left: 6px">
                Dear {{ $data['name']}};
            </p>
            <p style="margin-left: 6px">
                You are receiving this email because we received a file service download on <a href="https://portal.eagletunedinternational.com">{{ $data['company_name'] }}</a>.
            </p>
            <p style="margin-left: 6px" align="center">
                        <a href="https://portal.eagletunedinternational.com/download/comment/{{ $data['id'] }}" style="color: #fff;
                        background-color: #20a8d8;
                        border-color: #20a8d8;
                        display: inline-block;
                        font-weight: 400;
                        text-align: center;
                        white-space: nowrap;
                        vertical-align: middle;
                        -webkit-user-select: none;
                        -moz-user-select: none;
                        -ms-user-select: none;
                        user-select: none;
                        border: 1px solid transparent;
                        padding: 0.375rem 0.75rem;
                        font-size: 0.875rem;
                        line-height: 1.5;
                        border-radius: 0;
                    ">Download</a>
            </p>
            <p style="margin-left: 6px">
                If you did not request comment file, no further action is required.
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