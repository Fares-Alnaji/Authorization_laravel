<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $appends = ['active_key'];

    public function getActiveKeyAttribute(){
        return $this->active ? 'Active' : 'In-Active';
    }
}
