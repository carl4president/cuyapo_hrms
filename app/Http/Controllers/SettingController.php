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
        $companySettings = CompanySettings::where('id', 1)->first();
        return view('settings.companysettings', compact('companySettings'));
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
}
