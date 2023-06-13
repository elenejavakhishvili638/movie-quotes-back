<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Laravel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
</head>

<body
    style="background: linear-gradient(187.16deg, #181623 0.07%, #191725 51.65%, #0D0B14 98.75%);padding-left:194px;padding-bottom:109px;padding-right:195px;padding-top:79px">
    <div style='width:100%'>
        <div style="padding:16px; max-width:520px; margin:0 auto;">
            <img style="width:22px;height:20px;margin-bottom:56px;" data-image-whitelisted class="CToWUd a6T"
                data-bit="iit" tabindex="0" src="https://i.ibb.co/Vg8cnJB/Vector.png" />
            <p style="color:#DDCCAA;margin-top:10px;font-size:12px;font-weight:500;margin:0 auto;">MOVIE QUOTES</p>
        </div>
        <div style="margin-top:73px;align-text:left;">
            <p style="margin-bottom:24px">Hola {{ $user->username }}!</p>
            <p>Thanks for joining Movie quotes! We really appreciate it. Please click the button below to verify your
                account:</p>
            <a href="{{ $url }}" target="_blank"
                style="background-color:#E31221;display:block;padding-bottom:10px;padding-top:10px;padding-left:13px;padding-right:13px;max-width:128px;border-radius:4px;color:#fff;font-weight:700;margin-bottom:40px;text-decoration:none;text-align:center;font-size:16px;outline:none">Verify
                Email</a>
            <p>If clicking doesn't work, you can try copying and pasting it to your browser:</p>
            <a href="{{ $url }}">{{ $url }}</a>
            <p style="margin-top:40px;margin-borrom:24px">If you have any problems, please contact us:
                support@moviequotes.ge</p>
            <p>MovieQuotes Crew</p>
        </div>
    </div>
</body>
