<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\PasskeyUser;
use Laravel\Fortify\PasskeyAuthenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;

#[Fillable([
    'organization_id',
    'name',
    'email',
    'password',
    'role',
])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable implements PasskeyUser {
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, PasskeyAuthenticatable, TwoFactorAuthenticatable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array {
        return [
            'role' => UserRole::class,
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function organization(): BelongsTo {
        return $this->belongsTo(Organization::class);
    }

    public function createdWorkOrders(): HasMany {
        return $this->hasMany(WorkOrder::class, 'created_by');
    }

    public function comments(): HasMany {
        return $this->hasMany(WorkOrderComment::class);
    }

    public function workOrderAttachments(): HasMany {
        return $this->hasMany(WorkOrderAttachment::class, 'uploaded_by');
    }
    public function assignedWorkOrders(): BelongsToMany {
        return $this->belongsToMany(
            WorkOrder::class,
            table: "work_order_assignments",
            foreignPivotKey: 'user_id',
            relatedPivotKey: 'work_order_id',
        )->using(WorkOrderAssignment::class)
            ->withPivot([
                'assigned_by',
                'assigned_at',
                'created_at',
                'updated_at',
            ]);
    }

    public function assignments(): HasMany {
        return $this->hasMany(WorkOrderAssignment::class);
    }
    public function assignedByRecords(): HasMany {
        return $this->hasMany(WorkOrderAssignment::class, 'assigned_by');
    }
    public function initials(): string {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
}
