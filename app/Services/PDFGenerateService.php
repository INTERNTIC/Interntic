<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\InternshipRequest;
use App\Traits\GeneralTrait;
use Carbon\Carbon;


class PDFGenerateService
{
    use GeneralTrait;
    public function get_pdf(InternshipRequest $internshipRequest)
    {
        $student = $internshipRequest->student;
        $internship_responsible = $internshipRequest->internship_responsible();
        $file_name = $internshipRequest->id ."_". $student->id."_certeficate.pdf";
        if(!$this->is_pdf_exists($file_name)){
            $this->generate_pdf($student,$internship_responsible,$internshipRequest,$file_name);
        }
        return ['pdf_url' => url("Pdfs/".$file_name)];
    }

    public function calculate_durations($start_date, $end_date)
    {

        $date1 =  Carbon::parse($start_date);
        $date2 =  Carbon::parse($end_date);

        // Calculate the difference between the two dates
        return $date1->diffInDays($date2);
    }

    public function is_pdf_exists($file_name)
    {
        return Storage::exists('public/pdfs/'.$file_name);
    }
    
    public function generate_pdf($student,$internship_responsible,$internshipRequest,$file_name)
    {
        $data = [
            "student_full_name" => $student->first_name . " " . $student->last_name,
            "birthday" => date_format(date_create($student->birthday), 'Y-m-d'),
            "place_of_birth" => $student->place_of_birth,
            "duration" => $this->calculate_durations($internshipRequest->start_at, $internshipRequest->end_at) . " days",
            "company_name" => $internshipRequest->company->name . " " . $internshipRequest->company->location,
            "end_date" => date_format(date_create($internshipRequest->end_at), 'Y-m-d'),
            "internship_responsible_full_name" => $internship_responsible->first_name . " " . $internship_responsible->last_name,
        ];
        
        $view = view('certeficate.certaficate', $data)->render(); 

        $pdf = Pdf::setPaper("A4", 'landscape');
        $pdf->loadHTML($view);        
        $pdf->save(public_path("Pdfs/".$file_name));
    }
}
