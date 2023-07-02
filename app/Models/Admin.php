<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable implements MustVerifyEmail
{
    use HasFactory , HasRoles , Notifiable;

    protected $appends = ['active_key'];

    public function getActiveKeyAttribute(){
        return $this->active ? 'Active' : 'In-Active';
    }

    public function userName(): Attribute
    {
        return new Attribute(get: fn () => $this->name);
    }
}
