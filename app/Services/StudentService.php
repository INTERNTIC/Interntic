<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Student;
use App\Traits\SendEmail;
use App\Models\InternshipRequest;

class StudentService
{
    use SendEmail;
    public function accept_internship(InternshipRequest $accepted_internship)
    {
        $this->cancel_other_internships($accepted_internship);
        $accepted_internship->update(["status" => config('global.internship_request_status.accepted_by_student')]);
    }

    public function cancel_other_internships(InternshipRequest $accepted_internship)
    {
        $internships_accepted_by_internship_responsible = Student::find(auth()->id())->internshipsAcceptedByInternshipResponsible();
        $internships_accepted_by_internship_responsible->reject(function ($internship_item) use ($accepted_internship) {
            return $internship_item->id == $accepted_internship->id;
        })


            ->map(function ($internship_item) use ($accepted_internship) {
                if ($this->is_it_overlapping(
                    $accepted_internship->start_at,
                    $accepted_internship->end_at,
                    $internship_item->start_at,
                    $internship_item->end_at,
                )) {
                    $errorMsg = "
                    <script>alert(
                    `                   You have an internship overlapping the one
                    you are trying to accept
                    please delete this internship or change duration
                    details :
                    theme : $internship_item->theme
                    internship_responsible email : $internship_item->internshipResponsible_email`)</script>
                    You have an internship overlapping the one you are trying to accept
                    please delete this internship or change duration <br>
                    details :
                    theme : $internship_item->theme
                    internship_responsible email : $internship_item->internshipResponsible_email";
                    abort(422,$errorMsg);

                    // $data=["internship_request"=>$accepted_internship];
                    // $this->sendEmail($data,$internship_item->internshipResponsible_email,"CanceledInternship","CanceledInternship");
                    // $internship_item->delete();
                }
            });
        // TODO find other internships and cancel them or delete them if are ovalaping 

    }
    public function is_it_overlapping(
        $accepted_internship_start_at,
        $accepted_internship_end_at,
        $internship_start_at,
        $internship_end_at,
    ) {
        // if a internship is overlapping over than week it is gonna canceld 

        // Define the first date range
        $range1Start = Carbon::parse($accepted_internship_start_at);
        $range1End = Carbon::parse($accepted_internship_end_at);

        // Define the second date range
        $range2Start = Carbon::parse($internship_start_at);
        $range2End = Carbon::parse($internship_end_at);

        // Find the overlap between the date ranges
        $overlapStart = $range1Start->max($range2Start);
        $overlapEnd = $range1End->min($range2End);

        // Calculate the duration of the overlap in seconds
        $overlapDuration = $overlapEnd->diffInSeconds($overlapStart);

        // Calculate the number of seconds in a week
        $weekSeconds = 604800;

        // Check if the overlap duration is less than a week
        return $overlapDuration > $weekSeconds;
    }
}
