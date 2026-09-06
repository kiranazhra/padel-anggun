<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PromoController extends Controller
{
    public function index(): View
    {
        $promos = Promo::orderByDesc('is_active')->orderByDesc('created_at')->get();

        return view('admin.promo', ['promos' => $promos]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        Promo::create($validated + ['is_active' => true]);

        return back()->with('status', 'Promo "' . $validated['title'] . '" berhasil ditambahkan.');
    }

    public function update(Request $request, Promo $promo): RedirectResponse
    {
        $validated = $this->validated($request);

        $promo->update($validated);

        return back()->with('status', 'Promo "' . $promo->title . '" berhasil diperbarui.');
    }

    public function toggleActive(Promo $promo): RedirectResponse
    {
        $promo->update(['is_active' => ! $promo->is_active]);

        return back()->with(
            'status',
            $promo->is_active ? "Promo \"{$promo->title}\" sekarang aktif." : "Promo \"{$promo->title}\" dinonaktifkan."
        );
    }

    public function destroy(Promo $promo): RedirectResponse
    {
        $title = $promo->title;
        $promo->delete();

        return back()->with('status', "Promo \"{$title}\" telah dihapus.");
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'discount_value' => ['required', 'string', 'max:30'],
            'discount_label' => ['nullable', 'string', 'max:30'],
            'icon' => ['nullable', 'string', 'max:50'],
            'valid_until' => ['nullable', 'date'],
        ]);
    }
}
