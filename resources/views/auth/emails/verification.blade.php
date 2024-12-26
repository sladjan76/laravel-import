<html>

<head>
    <meta charset="UTF-8" content="width=device-width, initial-scale=1.0"/>
    <style type="text/css">
        @media only screen and (max-width:950px){
            .main {
                width: 90%;
                max-width: 100%;
            }
            img{
                width:100%
            }

            .logo a{
                width: 79px !important;
            }
            .main .logo{
                width: 55% !important;}

            h3 {
                font-size: 28px !important;
                line-height: 32px;
            }
        }

    </style>
</head>

<body style="margin:auto; padding: 0; background-color: #f5f5f5;overflow-x:hidden">
<div class="main" style="max-width:900px; font-family: Helvetica, sans-serif; margin:auto; padding-top:53px; padding-bottom: 20px; box-sizing:border-box; background-color: #f5f5f5;position:relative">

    <div style="background-color: rgb(255, 255, 255); box-shadow: 0 0 20px 0 #cecece; width: 100%; margin-top: 36px; padding: 53px 20px; box-sizing: border-box; font-size: 18px; margin-bottom: 30px; ">
        <div class="top-wrap" style="padding-bottom: 55px;">
            <div class="left-icon" style="display: inline-block;vertical-align: top;width: 20%;">
                <img src="https://api.holidayswap.com/left_icon.png"/>
            </div>
            <div class="logo" style="display: inline-block;vertical-align: top;width: 58%;text-align:center" >
                <a href="#" style="width: 117px;display: inline-block;">
                    {{--<img style="width: 117px !important;" src="https://api.holidayswap.com/logo.png"/>--}}
                </a>
            </div>
            <div class="right-icon" style="display: inline-block;vertical-align: top;width: 20%;">
                <img src="https://api.holidayswap.com/right_icon.png"/>
            </div>

        </div>

        <h3 style="margin-top:0; font-size: 40px; line-height: 30px; margin-bottom:48px; color:#242627;padding-bottom:20px;margin-bottom:0;text-align:center">Please verify your registration</h3>
        <p style="max-width: 456px;margin: auto;text-align: left;color:#242627;font-size:17px;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;line-height:25px;">
            For verification, click on the link below, or copy this link to your browser. <br />
            <a href="{{ $pending_email->content }}">{{ $pending_email->content }}</a>
        </p>

        <!-- 			<p style="margin-top:0;margin-bottom:0;text-align:center;padding:30px 0 66px;color: #ff6d2e;">
                        <a href="https://api.holidayswap.com/" style="font-size:18px;font-family: Helvetica;color: #ff6d2e;text-decoration: none;font-weight: bold;">Log back into the app</a>
                    </p> -->

        <div class="social" style="text-align: center;">
            <a href="https://twitter.com/" style="display:inline-block;vertical-align:top;padding: 0 10px 0 0;">
                <img src="https://api.holidayswap.com/twitter.png" />
            </a>
            &nbsp;
            <a href="https://www.instagram.com//" style="display:inline-block;vertical-align:top;padding: 0 10px;">
                <img src="https://api.holidayswap.com/insta.png"/>
            </a>


        </div>


        <div style="text-align: center;width:100%;">

            <p style="text-align: center; color:#b7b7b7; margin: 0px;font-size:14px;padding-top:20px">© BlueSky. All rights reserved.</p>

        </div>

    </div>

</div>

</body>

</html>