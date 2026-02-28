<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSiteSettingRequest;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        $setting = SiteSetting::query()->firstOrCreate(
            ['id' => 1],
            ['site_name' => 'AQUA POS']
        );

        return view('admin.settings.edit', compact('setting'));
    }

    public function update(UpdateSiteSettingRequest $request): RedirectResponse
    {
        $setting = SiteSetting::query()->firstOrCreate(
            ['id' => 1],
            ['site_name' => 'AQUA POS']
        );

        $validated = $request->validated();

        if ($request->hasFile('primary_logo')) {
            if ($setting->primary_logo) {
                Storage::disk('public')->delete($setting->primary_logo);
            }

            $validated['primary_logo'] = $request->file('primary_logo')->store('site-settings', 'public');
        }

        if ($request->hasFile('secondary_logo')) {
            if ($setting->secondary_logo) {
                Storage::disk('public')->delete($setting->secondary_logo);
            }

            $validated['secondary_logo'] = $request->file('secondary_logo')->store('site-settings', 'public');
        }

        $setting->update($validated);

        return redirect()->route('admin.settings.edit')->with('success', 'Site settings updated successfully.');
    }
}
