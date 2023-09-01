<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public function SubCategory()
    {
        return $this->belongsTo(SubCategory::class , 'sub_category_id' , 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id' , 'id');
    }
}
