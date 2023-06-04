<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <p>Dear internship responsible ,</p>

    <p>I hope this email finds you well. I wanted to inform you that a student has submitted an internship request and has been assigned to you as their internship head.</p>

    <p>An account has been created for you in our platform to facilitate the management of the internship process. Please find below your login credentials:</p>

    <p><strong>Email:</strong> {{$credentials['email']}} </p>
    <p><strong>Password:</strong> {{$credentials['password']}}</p>

    <p>With your account, you will have access to the intern's details, internship objectives, and any relevant documentation. You can also communicate directly with the student and provide guidance throughout their internship.</p>

    <p>Please log in to the platform using the provided credentials as soon as possible to review the internship request and proceed with the necessary steps. Should you have any questions or require assistance with the platform, please don't hesitate to reach out to our support team.</p>

    <p>you can login to your account via <a href="{{url('/login/internship_responsible')}}">Login</a></p>
    <p>Thank you for your cooperation and commitment to providing valuable internship experiences.</p>

    <p>Best regards,</p>

    <p>INTERNTIC TEAM.</p>

</body>

</html>