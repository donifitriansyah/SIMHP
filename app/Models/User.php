<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'username',
    'email',
    'password',
    'role',
    'irban_id',
    'status',
])]

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
            'status' => 'boolean',
        ];
    }

    public function canInputPemeriksaan(): bool
    {
        return in_array($this->role, [
            'super_user',
            'user_entry'
        ]);
    }

    public function canCreateLhp(): bool
    {
        return in_array($this->role, [
            'super_user',
            'user_entry'
        ]);
    }


    /**
     * Cek apakah user Super User
     */
    public function isSuperUser(): bool
    {
        return $this->role === 'super_user';
    }

    /**
     * Cek apakah user User Entry
     */
    public function isUserEntry(): bool
    {
        return $this->role === 'user_entry';
    }

    public function isUserView(): bool
    {
        return $this->role === 'user_view';
    }

    public function canEdit(): bool
    {
        return $this->isSuperUser();
    }

    public function canCreate(): bool
    {
        return $this->isSuperUser() || $this->isUserEntry();
    }

    public function canViewAll(): bool
    {
        return $this->isSuperUser();
    }

    public function canEditTindakLanjut(Lhp $lhp): bool
    {
        if ($this->isSuperUser()) {
            return true;
        }

        if ($this->isUserView()) {
            return false;
        }

        return EditRequest::where('lhp_id', $lhp->id)
            ->where('user_id', $this->id)
            ->where('status', 'approved')
            ->exists();
    }

    public function irban()
    {
        return $this->belongsTo(Irban::class);
    }
    public function editRequests()
    {
        return $this->hasMany(EditRequest::class);
    }

}
