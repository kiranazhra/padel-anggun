<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Court;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CourtController extends Controller
{
    public function index(): View
    {
        $courts = Court::orderBy('urutan')->orderBy('nama')->get();

        return view('admin.lapangan', ['courts' => $courts]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);

        $validated['slug'] = $this->uniqueSlug($validated['nama']);
        $validated['slot'] = $this->parseSlot($request->input('slot'));
        $validated['urutan'] = (int) Court::max('urutan') + 1;
        $validated['is_active'] = true;

        $court = Court::create($validated);

        return back()->with('status', "Lapangan \"{$court->nama}\" berhasil ditambahkan.");
    }

    public function update(Request $request, Court $court): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['slot'] = $this->parseSlot($request->input('slot'));

        $court->update($validated);

        return back()->with('status', "Lapangan \"{$court->nama}\" berhasil diperbarui.");
    }

    /**
     * Ubah status operasional harian (tersedia / pemeliharaan) beserta
     * catatan singkatnya, tanpa perlu buka form edit penuh — dipakai dari
     * tombol cepat di kartu lapangan. Status "digunakan" sengaja tidak ada
     * di sini karena itu dihitung otomatis dari reservasi aktif
     * (lihat Court::statusMeta()), bukan diset manual oleh admin.
     */
    public function updateStatus(Request $request, Court $court): RedirectResponse
    {
        if ($court->activeReservation()) {
            return back()->with('status', "Status \"{$court->nama}\" tidak bisa diubah manual — sedang \"Digunakan\" otomatis oleh reservasi yang berlangsung sekarang.");
        }

        $validated = $request->validate([
            'status' => ['required', 'in:tersedia,pemeliharaan'],
            'status_catatan' => ['nullable', 'string', 'max:150'],
        ]);

        $court->update($validated);

        return back()->with('status', "Status \"{$court->nama}\" diperbarui menjadi " . $court->statusMeta()['label'] . '.');
    }

    public function toggleActive(Court $court): RedirectResponse
    {
        $court->update(['is_active' => ! $court->is_active]);

        return back()->with(
            'status',
            $court->is_active
                ? "Lapangan \"{$court->nama}\" sekarang tampil di halaman pemesanan."
                : "Lapangan \"{$court->nama}\" disembunyikan dari halaman pemesanan."
        );
    }

    public function destroy(Court $court): RedirectResponse
    {
        if ($court->reservations()->exists()) {
            return back()->with('status', "Lapangan \"{$court->nama}\" tidak bisa dihapus karena masih punya riwayat reservasi. Nonaktifkan saja lapangan ini.");
        }

        $nama = $court->nama;
        $court->delete();

        return back()->with('status', "Lapangan \"{$nama}\" telah dihapus.");
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'lokasi' => ['nullable', 'string', 'max:150'],
            'tipe' => ['nullable', 'string', 'max:100'],
            'harga' => ['required', 'integer', 'min:0'],
            'harga_coret' => ['nullable', 'integer', 'min:0'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'gambar_utama' => ['nullable', 'url', 'max:2000'],
        ]);
    }

    /**
     * Slot ditulis admin sebagai teks jam dipisah koma, mis. "08:00, 10:00, 15:00".
     *
     * @return array<int, string>
     */
    private function parseSlot(?string $raw): array
    {
        if (! $raw) {
            return [];
        }

        return collect(explode(',', $raw))
            ->map(fn ($jam) => trim($jam))
            ->filter()
            ->values()
            ->all();
    }

    private function uniqueSlug(string $nama): string
    {
        $base = Str::slug($nama);
        $slug = $base;
        $i = 1;

        while (Court::where('slug', $slug)->exists()) {
            $slug = $base . '-' . (++$i);
        }

        return $slug;
    }
}
