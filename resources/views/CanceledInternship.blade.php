<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

    <body>
    <p>Dear {{$internship_request->internship_responsible()->first_name}} {{$internship_request->internship_responsible()->last_name}},</p>

    <p>I hope this email finds you well. I am writing to inform you that, unfortunately, I must cancel my internship request at {{$internship_request->internship_responsible()->company->name}} , {{$internship_request->internship_responsible()->company->location}}.</p>

    <p>I apologize for any inconvenience this may cause and I understand the impact it may have on your internship program. Due to unforeseen circumstances , I am unable to proceed with the internship opportunity at this time.</p>

    <p>I sincerely appreciate the consideration given to my application and the opportunity extended to me. I have great respect for {{$internship_request->internship_responsible()->company->name}} and its mission, and I am truly sorry for any disruption caused by my withdrawal.</p>

    <p>Thank you for your understanding. I hope to have the opportunity to connect with {{$internship_request->internship_responsible()->company->name}} in the future.</p>

    <p>Best regards,</p>

    <p>{{$internship_request->internship_responsible()->first_name}} {{$internship_request->internship_responsible()->last_name}}</p>
</body>
</html>