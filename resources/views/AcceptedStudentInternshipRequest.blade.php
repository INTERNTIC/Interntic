<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
<p>Dear {{$internship_request->student->first_name}} {{$internship_request->student->last_name}},</p>

<p>I hope this email finds you well. I am writing to inform you that your internship request has been accepted by {{$internship_request->internship_responsible()->company->name}}. We are delighted to offer you the opportunity to join our team as an intern in {{$internship_request->theme}}.</p>

<p>At {{$internship_request->internship_responsible()->company->name}}, we recognize the importance of providing practical experiences and opportunities for aspiring professionals like yourself. We believe that your skills, passion, and enthusiasm will make a valuable contribution to our organization.</p>

<p>Your acceptance into our internship program signifies our confidence in your abilities and potential. We are confident that this internship will provide you with valuable insights and hands-on experience in your chosen field of study. You will have the chance to work alongside our dedicated team of professionals who are committed to fostering a supportive and engaging environment for interns.</p>

<p>Please find attached a formal letter outlining the details of your internship, including the start date, duration, and any specific instructions or requirements for your first day. Kindly review the letter carefully and let us know if you have any questions or concerns.</p>

<p>We look forward to welcoming you to {{$internship_request->internship_responsible()->company->name}}. We are certain that this internship will be a mutually beneficial experience, allowing you to enhance your skills and knowledge while contributing to our ongoing projects and initiatives.</p>

<p>Once again, congratulations on your acceptance into our internship program. We are excited to embark on this journey with you and help you grow both personally and professionally.</p>

<p>Should you have any further inquiries or need any additional information, please do not hesitate to reach out to me. Thank you for choosing {{$internship_request->internship_responsible()->company->name}} for your internship, and we eagerly await your arrival.</p>

<p>Best regards,</p>

<p>Internship Responsible:<br>
{{$internship_request->internship_responsible()->first_name}} {{$internship_request->internship_responsible()->last_name}}<br>
{{$internship_request->internship_responsible()->company->name}} , {{$internship_request->internship_responsible()->company->location}}</p>

<p>Contact Information: {{$internship_request->internship_responsible()->email}}</p>
</body>

</html>