<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MembershipController extends Controller
{
    public function create(): View
    {
        return view('keanggotaan');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tier' => ['required', Rule::in(['gold', 'elite', 'premium'])],
            'terms' => ['accepted'],
        ], [
            'tier.required' => 'Pilih salah satu paket keanggotaan.',
            'terms.accepted' => 'Kamu harus menyetujui Syarat & Ketentuan.',
        ]);

        $request->user()->update(['membership_tier' => $validated['tier']]);

        return redirect()
            ->route('dashboard')
            ->with('status', 'Selamat! Kamu sekarang anggota paket ' . ucfirst($validated['tier']) . '.');
    }
}
