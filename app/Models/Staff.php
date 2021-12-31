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

    public function makeHod()
    {
        $this->isHod = true;
        $this->save();
    }

    public function unMakeHod()
    {
        $this->isHod = false;
        $this->save();
    }

    public function department()
    {
        return $this->belongsToMany(Department::class)->withTimestamps();
    }

    public function performance()
    {
        return $this->hasMany(Performance::class);
    }
}
