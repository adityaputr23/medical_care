<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingContent;
use Illuminate\Http\Request;

class LandingContentController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'hero_headline' => 'nullable|string|max:255',
            'hero_subheadline' => 'nullable|string',
            'emergency_banner' => 'nullable|in:true,false',
            'show_doctor_ratings' => 'nullable|in:true,false',
            'hero_bg_image' => 'nullable|image|max:5120',
        ]);

        if ($request->filled('hero_headline')) {
            LandingContent::setValue('hero_headline', $request->hero_headline);
        }
        if ($request->filled('hero_subheadline')) {
            LandingContent::setValue('hero_subheadline', $request->hero_subheadline);
        }
        
        LandingContent::setValue('emergency_banner', $request->has('emergency_banner') ? 'true' : 'false');
        LandingContent::setValue('show_doctor_ratings', $request->has('show_doctor_ratings') ? 'true' : 'false');

        if ($request->hasFile('hero_bg_image')) {
            $path = $request->file('hero_bg_image')->store('landing', 'public');
            LandingContent::setValue('hero_bg_image', $path);
        }

        return back()->with('success', 'Konten landing page berhasil diperbarui.');
    }
}
