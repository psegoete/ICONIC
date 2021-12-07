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

<div style="background-color: #e4e5e6; width: 100%; left: 0; right: 0;">
    <div style="width: 100%; background-color:#29363d; height:90px" align="center">
        <img src="http://register.iconiccodedevelopment.com/saas/img/ICD_Logo_PNG_1000px.png" alt="Eagle Eye International" height="80px"> </img>
    </div>
    <div style="margin-left: 5px; margin-right: 5px;margin-top: 25px;">
        <div style="background-color:white;margin-left: 5px; margin-right: 5px;margin-top: 25px;margin-bottom: 25px">
            <p style="margin-left: 6px">
                Hi there
            </p>
            <p style="margin-left: 6px">
                {{ $data['company_name']}} registered a platform and chose {{ $data['plan']}} plan.
            </p>

            @if( $data['credits'] == 1)
            <p style="margin-left: 6px">
                The Tenant wants to use a subdomain, and please add their subdomain on the server.
            </p>
            <p style="margin-left: 6px">
                Please assist within 48 hours.
            </p>
            @endif
            @if( $data['credits'] == 2)
                <p style="margin-left: 6px">
                    The Tenant wants to use their domain. In the meantime, add their domain to the server as an add on domain.
                </p>
            @endif
            @if( $data['credits'] == 3)
                <p style="margin-left: 6px">
                    The Tenant wants to use their domain. AOLC On-Line will help them and let you know once done.
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