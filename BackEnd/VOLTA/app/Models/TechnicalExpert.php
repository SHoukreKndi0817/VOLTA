<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Client;
use Illuminate\Support\Carbon;
use App\Models\SolarSystemInfo;
use App\Models\RequestEquipment;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class TechnicalExpert extends Authenticatable
{
    use HasFactory, HasApiTokens , Notifiable;

    protected $primaryKey = 'technical_expert_id';

    protected $fillable = [
        'technical_expert_id',
        'name',
        'phone_number',
        'home_address',
        'user_name',
        'password',
        'admin_id',
        'is_active'
    ];

    protected $hidden = ['password'];


    public function getDaysWorkedAttribute()
    {
        // حساب الفرق بين created_at والتاريخ الحالي
        return Carbon::parse($this->created_at)->diffInDays(Carbon::now());
    }
    public function Client()
    {
        return $this->hasMany(Client::class, 'technical_expert_id');
    }
    public function Admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
    public function RequestEquipment()
    {
        return $this->hasMany(RequestEquipment::class, 'technical_expert_id');
    }
    public function SolarSystemInfo()
    {
        return $this->hasMany(SolarSystemInfo::class, 'technical_expert_id');
    }
    public function Rating()
    {
        return $this->hasMany(Rating::class, 'technical_expert_id');
    }
}
