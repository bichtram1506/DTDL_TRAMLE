<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Shanmuga\LaravelEntrust\Models\EntrustRole;
use Illuminate\Support\Facades\Config;

class Role extends EntrustRole
{
    use HasFactory;
    protected $table = 'roles';
    public $timestamps = true;

    protected $fillable = [
        'name', 'display_name', 'description','created_at','updated_at'
    ];

    public function permissionRole()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id');
    }

    public function staffs()
    {
        return $this->belongsToMany(Staff::class, 'role_staff', 'role_id', 'staff_id');
    }
}
