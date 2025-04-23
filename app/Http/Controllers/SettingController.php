<?php

namespace App\Http\Controllers;

use App\Models\RolesPermissions;
use App\Models\CompanySettings;
use Illuminate\Http\Request;
use DB;

class SettingController extends Controller
{
    /** Company Settings Page */
    public function companySettings()
    {
        $companySettings = CompanySettings::where('id',1)->first();
        return view('settings.companysettings',compact('companySettings'));
    }

    /** Save Record Company Settings */
    public function saveRecord(Request $request)
{
    $request->validate([
        'company_name'     => 'required|string|max:255',
        'municipal_mayor'  => 'required|string|max:255',
        'logo'             => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    try {
        $logoName = null;
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = time() . '.' . $logo->extension();
            $logo->move(public_path('assets/images'), $logoName);
        }

        $settings = CompanySettings::updateOrCreate(
            ['id' => $request->id],
            [
                'company_name'    => $request->company_name,
                'municipal_mayor' => $request->municipal_mayor,
                'logo'            => $logoName ?? CompanySettings::find($request->id)?->logo,
            ]
        );

        flash()->success('Company settings saved successfully!');
        return redirect()->back();
    } catch (\Exception $e) {
        \Log::error($e);
        flash()->error('Failed to save company settings.');
        return redirect()->back();
    }
}
    
    /** Roles & Permissions  */
    public function rolesPermissions()
    {
        $rolesPermissions = RolesPermissions::All();
        return view('settings.rolespermissions',compact('rolesPermissions'));
    }

    /** Add Role Permissions */
    public function addRecord(Request $request)
    {
        $request->validate([
            'roleName' => 'required|string|max:255',
        ]);
        
        DB::beginTransaction();
        try {
            $roles = RolesPermissions::where('permissions_name', '=', $request->roleName)->first();
            if ($roles === null) {
                // roles name doesn't exist
                $role = new RolesPermissions;
                $role->permissions_name = $request->roleName;
                $role->save();
            } else {
                // roles name exits
                DB::rollback();
                flash()->error('Roles name exits :)');
                return redirect()->back();
            }

            DB::commit();
            flash()->success('Create new role successfully :)');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            flash()->error('Logout successfully :)');
            return redirect()->back();
        }
    }

    /** Edit Roles Permissions */
    public function editRolesPermissions(Request $request)
    {
        DB::beginTransaction();
        try{
            $id        = $request->id;
            $roleName  = $request->roleName;
            
            $update = [
                'id'               => $id,
                'permissions_name' => $roleName,
            ];

            RolesPermissions::where('id',$id)->update($update);
            DB::commit();
            flash()->success('Role Name updated successfully :)');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            flash()->error('Role Name update fail :)');
            return redirect()->back();
        }
    }

    /** Delete Roles Permissions */
    public function deleteRolesPermissions(Request $request)
    {
        try {
            RolesPermissions::destroy($request->id);
            flash()->success('Role Name deleted successfully :)');
            return redirect()->back();
        } catch(\Exception $e) {
            DB::rollback();
            flash()->error('Role Name delete fail :)');
            return redirect()->back();
        }
    }

    /** Localization */
    public function localizationIndex()
    {
        return view('settings.localization');
    }

    /** Salary Settings */
    public function salarySettingsIndex()
    {
        return view('settings.salary-settings');
    }

    /** Email Settings */
    public function emailSettingsIndex()
    {
        return view('settings.email-settings');
    }
}
