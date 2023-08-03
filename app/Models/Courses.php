<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    use HasFactory;
    protected $table = 'courses';
    protected $fillable = [
        'course_id',
        'course_name',
        'course_description',
    ];

    //relationships
    public function teachers()
    {
        return $this->belongsTo(Teacher::class, 'regNo', 'regNo');

    } 
    public function units()
    {
        return $this->hasMany(Unit::class, 'course_id','course_id');

    } 

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'course_id', 'course_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments', 'course_id', 'regNo');
    }

}
