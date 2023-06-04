<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    Dear {{$internship_request->internship_responsible()->first_name}} {{$internship_request->internship_responsible()->last_name}},

    I hope this email finds you well. I am writing to formally accept the internship offer at {{$internship_request->internship_responsible()->company->name}}. I am thrilled and honored to have been selected for this opportunity and I am eager to contribute to the team.

    My name is{{$internship_request->student->first_name}} {{$internship_request->student->last_name}}, and I am currently a {{$internship_request->student->level_major->level->name}}  student at [University/Institution Name], pursuing a degree in {{$internship_request->student->level_major->major->name}}. Throughout my academic journey, I have developed a strong passion for {{$internship_request->theme}}. The internship at {{$internship_request->internship_responsible()->company->name}} aligns perfectly with my career aspirations and I am excited to learn and grow in such a dynamic environment.

    I am grateful for the chance to work alongside the talented professionals at {{$internship_request->internship_responsible()->company->name}}. I believe this internship will provide me with invaluable experience, allowing me to apply the knowledge and skills I have acquired during my studies. I am eager to contribute my fresh perspective, dedication, and enthusiasm to support the goals and objectives of the team.

    Please let me know if there are any additional steps or paperwork I need to complete before my start date. I am available to attend any orientation sessions or training programs as required. Also, kindly inform me of the designated start date, as well as the duration and any specific instructions or documents I need to bring on my first day.

    Once again, I would like to express my sincere appreciation for extending this opportunity to me. I look forward to joining the {{$internship_request->internship_responsible()->company->name}} team and making a positive contribution.

    Thank you for your time and consideration.

    Yours sincerely,

   {{$internship_request->student->first_name}} {{$internship_request->student->last_name}} 
    Contact Information: {{$internship_request->student->email}} 
</body>

</html>