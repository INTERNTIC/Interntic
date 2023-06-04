<?php


namespace App\Http\Controllers;

use App\Models\SuperAdmin;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    use GeneralTrait;
    public function __construct() {
        abort_if(!Auth::getDefaultDriver() == config('global.super_admin_guard'), 403);
    }
    public function index()
    {
        $super_admins=SuperAdmin::all();
        return $this->returnData($super_admins);
    }
    public function store(Request $request)
    {
        $super_admins=SuperAdmin::create($request->validate());
        return $this->returnData($super_admins);
    }
    public function show(SuperAdmin $super_admin)
    {
        return $this->returnData($super_admin);
    }
    public function update(Request $request, SuperAdmin $superAdmin)
    {
        // TODO Gate
        $request->validate([
            'email' => ['required', 'email', 'ends_with:univ-constantine2.dz', 'unique:super_admins,email,'.$superAdmin->id],
        ]);
        $superAdmin->update(["email" => $request->email]);
        return $this->returnData($superAdmin, "Updated Successfully");
    }
    public function delete(SuperAdmin $super_admin)
    {
        $super_admin->delete();
        return $this->returnSuccessMessage("Deleted Successfully");
    }
}
