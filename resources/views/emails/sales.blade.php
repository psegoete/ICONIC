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
                Hi AOLC On-Line
            </p>

            <p style="margin-left: 6px">
                This is Iconic Code Development. A new client has registered to our platform and selected to have a custom website build.</br>
                We have agreement with AOLC that Iconic Code Development will pay for this. Please log a ticket with the below details.
            </p>

            <p style="margin-left: 6px">
                {{ $data['company_name']}} would like help to create a new domain ({{ $data['domain']}}). Please check the domain availability
                and register the domain. Please see the below contact details to contact the client for their website info.</br>
            </p>
            <p style="margin-left: 6px">
                Company email: {{ $data['company_email']}}
            </p>
            
            <p style="margin-left: 6px">
                Company tel/phone number: {{ $data['company_phone']}}
            </p>
            
            <p style="margin-left: 6px">
                Tenant email: {{ $data['email']}}
            </p>
            
            
            <p style="margin-left: 6px">
                Domain name: {{ $data['domain']}}
            </p>

            <p style="margin-left: 6px">
                Remember to add a platform page on the new website pointing to this IP Address: 5.189.174.191
            </p>

            <p style="margin-left: 6px">
                If a differnt domain name had to be chosen. Please inform Marnes at {{ $data['iconic_email']}} with 
                the new domain name and company name ({{ $data['company_name']}}) so that he can update his system.
            </p>

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