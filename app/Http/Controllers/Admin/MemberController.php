<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberController extends Controller
{
    /**
     * List real registered accounts, with reservation count and payment
     * status computed from real data, plus optional search by name/email.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $members = User::query()
            ->withCount('reservations')
            ->withSum(['reservations as total_terkonfirmasi' => function ($query) {
                $query->where('status', 'terkonfirmasi');
            }], 'total_harga')
            ->withCount(['reservations as reservasi_menunggu_count' => function ($query) {
                $query->where('status', 'menunggu_konfirmasi');
            }])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(9)
            ->withQueryString();

        return view('admin.anggota', [
            'members' => $members,
            'search' => $search,
        ]);
    }

    /**
     * Grant or revoke admin access for a member.
     */
    public function toggleAdmin(Request $request, User $member): RedirectResponse
    {
        if ($member->is($request->user())) {
            return back()->with('status', 'Kamu tidak bisa mengubah status admin akunmu sendiri.');
        }

        $member->update(['is_admin' => ! $member->is_admin]);

        return back()->with(
            'status',
            $member->is_admin
                ? "{$member->name} sekarang menjadi admin."
                : "{$member->name} bukan admin lagi."
        );
    }

    /**
     * Remove a member account.
     */
    public function destroy(Request $request, User $member): RedirectResponse
    {
        if ($member->is($request->user())) {
            return back()->with('status', 'Kamu tidak bisa menghapus akunmu sendiri.');
        }

        $member->delete();

        return back()->with('status', "Akun {$member->name} telah dihapus.");
    }
}
