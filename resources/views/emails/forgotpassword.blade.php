<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Forgot Password Email</title>
</head>
<body>

<table>
    <tr>
        <td>
            Dear {{ $name }}!
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>Your account has been successfully Updated <br/>
            Your account information is as below with new Password </td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>Email: {{ $email }} </td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>New Password: {{ $password }} </td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td> Thanks & Regards,</td></tr>
    <tr><td> E-com Website </td></tr>
</table>

</body>
</html>