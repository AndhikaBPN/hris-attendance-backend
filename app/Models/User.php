<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'division_id',
        'position_id',
        'manager_id',
        'employee_card_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'address',
        'photo',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey(); // id user
    }

    public function getJWTCustomClaims()
    {
        return [
            'id' => $this->id,
            'role_id' => $this->role_id,
        ];
    }

    // Relasi
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'user_id');
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class, 'user_id');
    }

    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class, 'user_id');
    }

    // Manager (atasan)
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    // Bawahan (subordinates)
    public function subordinates()
    {
        return $this->hasMany(User::class, 'manager_id');
    }
}
