<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id' , 'id');
    }

    public function tasks()
    {
        return $this->hasManyThrough(Task::class, SubCategory::class , 'category_id' , 'sub_category_id');
    }
}
