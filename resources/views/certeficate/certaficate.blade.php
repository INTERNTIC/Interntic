<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="certaficate/certaficate.css">
    <title>Document</title>
</head>

<body>
    <div class="header">
        <h1>Algerian Republic Democratic And Popular</h1>
        <h1 class="title">INTERNSHIP CERTIFICATE</h1>
    </div>


    <section class="first_section underline">
        <div class="text sans">
            This is to certify that
        </div>

        <div class="name cursive">
        {{$student_full_name}}
        </div>

        <div>
            Born at {{$birthday}}, {{$place_of_birth}}
        </div>
    </section>

    <div class="paragraph">
        has successfully completed {{$duration}} internship program with {{$company_name}}.
    </div>

    <div class="paragraph">
        During the internship, {{$student_full_name}}  has demonstrated a high level of enthusiasm, dedication, and commitment towards learning and contributing to the organization.
        The intern has completed various tasks and projects assigned to him efficiently and effectively.
    </div>

    <div class="paragraph">
        Based on the intern's performance and achievements, we are pleased to award this Internship Certificate as recognition of their hard work and contribution to the organization.
    </div>

    <div class="footer ">


        <div style="float: right; width: 15%; ">
            DATE
            <br>
            {{$end_date}}
        </div>
        <div style="float: left;">
            INTERNSHIP RESPONSIBLE
            <br>
            {{$internship_responsible_full_name}}
        </div>
        <div style="margin-left: 46%; width: 25%; ">
            COMPANY CEO
            <br>
            {{$company_name}}
        </div>

    </div>
</body>

</html>