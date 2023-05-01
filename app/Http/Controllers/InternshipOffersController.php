<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OfferRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OfferResource;
use Illuminate\Support\Facades\Validator;

class InternshipOffersController extends Controller
{
    use GeneralTrait;
    
        public function displayOffers()
        {
            if (Auth::getDefaultDriver() == config('global.internship_responsible_guard')) {
                $user_id = Auth::guard('internship_responsible')->id();
                $offers = Offer::where('internship_responsible_id', $user_id)->paginate(3);
            } else if (Auth::getDefaultDriver() == config('global.student_guard')) {
                $offers=Offer::paginate(3);
            }
            return $this->returnData( OfferResource::collection($offers));
        }
    public function addOffer(OfferRequest $request)
    {
        $user = Auth::guard('internship_responsible')->user();
        abort_if(!$user, 403);
        $responsible_id = $user->id;
        $offer = Offer::create($request->validated() + ["internship_responsible_id" => $responsible_id]);
        return $this->returnData(new OfferResource($offer), "created Successfully");
    }

    public function selectOffer(Offer $offer)
    {
        return $this->returnData($offer);
    }

    public function editOffer(OfferRequest $request, Offer $offer)
    {
        $offer->update($request->validated());
        return $this->returnSuccessMessage("Updated Successfully");
    }

    public function deleteOffer(Offer $offer)
    {
        $offer->delete();
        return $this->returnSuccessMessage("Deleted Successfully");
    }
}
