<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $table = 'teachers';
    protected $fillable = [
        'teacher_name',
        'email',
        'regNo',
    ];
    public function courses()
    {
        return $this->hasMany(Courses::class, 'teacher_id', 'id');
    }
}
