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
a:link {
  text-decoration: none;
}

    </style>
</head>
<body>

<div style="background-color: #e4e5e6; width: 100%; left: 0; right: 0;">
        <div style="width: 100%; background-color:#29363d; height:90px" align="center">
            <img src="http://register.iconiccodedevelopment.com/saas/img/ICD_Logo_PNG_1000px.png" alt="Eagle Eye International" height="80px"> </img>
        </div>
        <div style="margin-left: 5px; margin-right: 5px;margin-top: 25px;">
            <div style="background-color:white;margin-left: 5px; margin-right: 5px;margin-top: 25px;margin-bottom: 25px">
                <p style="margin-left: 6px">
                    Hi {{$data['customer_name']}} 
                </p>
                <p style="margin-left: 6px">
                    We received a company registration request for your platform on Iconic Code Development.
                </p>
                <p style="margin-left: 6px" align="center">
                            <a href="{{ url('/companies/payment/'.$data['token']) }}" style="color: #fff;
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
                            text-decoration: none;
                        ">Would you please pay R{{ $data['amount']}} to active your platform</a>
                </p>
                <p style="margin-left: 6px">
                    If you experience any problems, don't hesitate to get in touch with Iconic Code Development.
                </p>
                <p style="margin-left: 6px">
                    Email: {{ $data['iconic_email'] }}
                </p>
                <p style="margin-left: 6px">
                    Kind regards,
                </p>
                <p style="margin-left: 6px">
                   {{ $data['company_name'] }}
                </p>
            </div>
        </div>
</div>
</body>
</html>