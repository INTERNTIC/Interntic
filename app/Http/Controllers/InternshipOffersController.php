<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\DB;
use App\Traits\GeneralTrait;

class InternshipOffersController extends Controller
{
    use GeneralTrait;
    public function addOffer(OfferRequest $request)
    {
        $user = Auth::guard('internship_responsible')->user();
        abort_if(!$user,403);
        $responsible_id=$user->id;
        $offer=Offer::create($request->validated()+["internship_responsible_id"=>$responsible_id]);
        return $this->returnData($offer,"created Successfully");

    }

    public function displayOffers()
    {
        $user = Auth::guard('internship_responsible')->user();
        abort_if(!$user,403);
        $offers=Offer::where('internship_responsible_id',$user->id)->paginate(3);
        return $this->returnData($offers);
    }

    public function selectOffer(Offer $offer)
    {
        return $this->returnData($offer);
    }

    public function editOffer(OfferRequest $request,Offer $offer)
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