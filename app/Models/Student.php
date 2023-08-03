<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';
    protected $fillable = [
        'regNo',
        'student_name',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'regNo', 'regNo');
    }
    public function mark()
    {
        return $this->hasMany(Mark::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'regNo', 'course_id');
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'regNo', 'unit_id');
    }
}
