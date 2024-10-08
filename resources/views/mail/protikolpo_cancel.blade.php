<!doctype html>
<html lang="en-US">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
    <title>Password Reset</title>
    <style type="text/css">
        a:hover {
            text-decoration: underline !important;
        }

        @font-face {
            font-family: SolaimanLipi;
            src: url('{{asset('/fonts/SolaimanLipi.ttf') }}');
        }
    </style>
</head>

<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0; background-color: #f2f3f8;" leftmargin="0">
<table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8">
    <tr>
        <td>
            <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0"
                   align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td style="height:80px;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align:center;">
                        <a href="" title="logo" target="_blank">
                            <img width="60" src="{{asset('assets/img/doptor.png')}}" title="logo"
                                 alt="logo">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="height:20px;">&nbsp;</td>
                </tr>
                <tr>
                    <td>
                        <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                               style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                            <tr>
                                <td style="height:40px;">&nbsp;</td>
                            </tr>
                            <tr>

                                <td style="padding:0 35px;">
                                    <h3 style="color:#1e1e2d; font-weight:500; margin:0;font-size:22px;font-family:'Rubik',sans-serif;">
                                        <span style="font-weight: bold;">{{$details['body']['protikolpo_name']}}</span>
                                        Its plan has been suspended.
                                    </h3>
                                    <span
                                        style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
                                    <div style="margin:0 auto;width: 200px;text-align: left;">
                                        <p style="color:#455056; font-size:16px;line-height:24px; margin:0;">
                                            Username : {{$details['body']['username']}}
                                        </p>
                                        <p style="color:#455056; font-size:16px;line-height:24px; margin:0;">
                                            Date : {{$details['body']['date']}} </p>
                                        <p style="color:#455056; font-size:16px;line-height:24px; margin:0;">
                                            Time : {{$details['body']['time']}}
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="height:40px;">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                <tr>
                    <td style="height:20px;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align:center;">
                        <p style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">
                            &copy; <strong>{{env('APP_URL')}}</strong></p>
                    </td>
                </tr>
                <tr>
                    <td style="height:80px;">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!--/100% body table-->
</body>

</html>
