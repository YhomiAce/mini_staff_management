<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'isHod',
        'department_id',

    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function department()
    {
        return $this->belongsToMany(Department::class);
    }
}
