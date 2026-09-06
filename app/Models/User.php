<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'phone', 'password', 'is_admin', 'membership_tier'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Whether this user has admin privileges.
     */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Human-readable label for the membership tier badge, or null if the
     * user has never registered for a paid membership package.
     */
    public function membershipLabel(): ?string
    {
        return match ($this->membership_tier) {
            'gold' => 'Gold',
            'elite' => 'Elite',
            'premium' => 'Premium',
            default => null,
        };
    }

    /**
     * Real perk list matching what's shown on the membership signup page,
     * so the dashboard reflects the tier the user actually chose.
     *
     * @return array<int, string>
     */
    public function membershipPerks(): array
    {
        return match ($this->membership_tier) {
            'gold' => [
                'Booking lapangan H-2',
                'Diskon 10% di pro shop',
            ],
            'elite' => [
                'Booking lapangan H-5',
                'Diskon 15% di pro shop',
                '1 sesi coaching gratis/bulan',
            ],
            'premium' => [
                'Booking lapangan H-14',
                'Loker VIP pribadi',
                'Akses lounge eksklusif',
            ],
            default => [],
        };
    }
}
