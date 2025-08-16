<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['role','joined_at'])
            ->withTimestamps();
    }

}
