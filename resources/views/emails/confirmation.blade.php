<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Register Email</title>
</head>
<body>

<table>
    <tr>
        <td>
            Dear {{ $name }}!
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>Please click on below link to activate your account: </td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>Email: {{ $email }}</td></tr>
    <tr><td><a href="{{ url('confirm/'.$code) }}">Confirm Account</a></td></tr>

    <tr><td>Thanks & Regards,</td></tr>
    <tr><td>E-con Website </td></tr>
</table>

</body>
</html>