<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coach;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    /**
     * Tambah pelatih baru. Halamannya sendiri (index) di-render lewat
     * CoachScheduleController@index — controller ini cuma menangani aksi
     * tulis (create/update/delete/toggle) supaya tetap satu halaman.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'specialty' => ['nullable', 'string', 'max:150'],
            'fee' => ['required', 'integer', 'min:0'],
        ]);

        Coach::create([
            'name' => $validated['name'],
            'specialty' => $validated['specialty'] ?? null,
            'fee' => $validated['fee'],
            'is_active' => true,
        ]);

        return back()->with('status', 'Pelatih "' . $validated['name'] . '" berhasil ditambahkan.');
    }

    public function update(Request $request, Coach $coach): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'specialty' => ['nullable', 'string', 'max:150'],
            'fee' => ['required', 'integer', 'min:0'],
        ]);

        $coach->update([
            'name' => $validated['name'],
            'specialty' => $validated['specialty'] ?? null,
            'fee' => $validated['fee'],
        ]);

        return back()->with('status', 'Data pelatih "' . $coach->name . '" berhasil diperbarui.');
    }

    /**
     * Aktif/nonaktifkan pelatih. Pelatih nonaktif tidak muncul di form
     * pemilihan pelatih saat member memesan lapangan, dan tidak muncul di
     * grid jadwal pelatih, tapi riwayat sesinya tetap tersimpan.
     */
    public function toggleActive(Coach $coach): RedirectResponse
    {
        $coach->update(['is_active' => ! $coach->is_active]);

        return back()->with(
            'status',
            $coach->is_active
                ? "{$coach->name} sekarang aktif."
                : "{$coach->name} dinonaktifkan."
        );
    }

    /**
     * Hapus pelatih beserta seluruh sesinya (cascade lewat foreign key).
     * Diblokir kalau pelatih ini masih punya reservasi aktif (belum
     * dibatalkan) — supaya riwayat reservasi member tidak kehilangan jejak
     * pelatihnya dan jadwal tidak "bolong" tanpa penjelasan. Admin harus
     * menonaktifkan pelatih itu saja kalau memang sudah tidak dipakai lagi.
     */
    public function destroy(Coach $coach): RedirectResponse
    {
        $reservasiAktif = $coach->reservations()->where('status', '!=', 'dibatalkan')->count();

        if ($reservasiAktif > 0) {
            return back()->with(
                'status',
                "{$coach->name} tidak bisa dihapus karena masih terhubung dengan {$reservasiAktif} reservasi aktif. Nonaktifkan saja pelatihnya (ikon mata) supaya riwayat reservasi & jadwal tetap tersimpan."
            );
        }

        $name = $coach->name;
        $coach->delete();

        return back()->with('status', "Pelatih {$name} telah dihapus beserta jadwalnya.");
    }
}
