<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
Dear {{$internship_request->student->first_name}} {{$internship_request->student->last_name}},

I hope this email finds you well. I regret to inform you that after careful consideration, {{$internship_request->student->level_major->major->department->name}} has decided to decline your internship request at this time.

We appreciate your interest in our organization and your eagerness to gain practical experience in your chosen field. However, after reviewing your application, we have determined that we are unable to accommodate your request for the following reason(s): {{$department_cause->cause}}.

We understand that this news may be disappointing, but please remember that there are various factors involved in the selection process, and our decision does not reflect on your capabilities or potential. We encourage you to continue exploring other internship opportunities and to pursue your career goals with determination and enthusiasm.

We sincerely appreciate your interest in {{$internship_request->student->level_major->major->department->name}} and wish you the best in your future endeavors. If you have any further questions or require additional feedback, please feel free to reach out to us.
@if($status)
<p>Note: Our decision is final and not subject to modification.</p>
@endif
Thank you for your understanding.


Thank you for your understanding.

Best regards,

{{$internship_request->student->level_major->major->department->name}}
department head
</body>

</html>