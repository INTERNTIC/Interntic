<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="shortcut icon" href="assets/images/favicon.ico"> -->
    <title>Laravel</title>
    <!-- App css -->
    <style>
     
    </style>

</head>
<body>
    <p>student dashboard: <a href="{{url('login/student')}}">student dashboard</a> </p>
    <p>internship_responsible dashboard: <a href="{{url('login/internship_responsible')}}">student dashboard</a> </p>
    <p>department_head dashboard: <a href="{{url('login/department_head')}}">student dashboard</a> </p>
    <p>super_admin dashboard: <a href="{{url('login/super_admin')}}">student dashboard</a> </p>
</body>
<script>
   
</script>
</html>