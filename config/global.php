<?php
return[
"super_admin_guard"=>"super_admin",
"internship_responsible_guard"=>"internship_responsible",
"department_head_guard"=>"department_head",
"student_guard"=>"student",
"internship_request_status"=>[
    "not_seen"=>0,
    "accepted_by_department_head"=>1,
    "refused_by_department_head"=>2,
    "refused_by_internship_responsible"=>3,
    "accepted_by_internship_responsible"=>4,
    "accepted_by_student"=>5,
],
"guards"=>array("student","internship_responsible","department_head","super_admin"),
];
?>