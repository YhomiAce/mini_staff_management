<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function staff()
    {
        return $this->belongsToMany(Staff::class);
    }
}
