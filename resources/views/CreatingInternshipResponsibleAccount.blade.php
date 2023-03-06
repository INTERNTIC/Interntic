<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <b>Dear Student</b>,<br><br>
    We hope your are doing well,<br>
    you account is create ,get credentials<br>
    email:<b> </b><br>
    password:<b> </b><br>
    get into platform
    <b>To do that you may click here</b> : <a href="">Verify my account</a><br>
    Good luck!

    INTERNTIC TEAM.
    @if(isset($credentials))
    echo "if";
    <?php var_dump($credentials); ?>
    @else
    echo "else";
    <?php var_dump($internshipResponsible); ?>
    @endif

</body>

</html>