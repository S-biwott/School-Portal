<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;
    protected $table = 'enrollments';
    //disables the created_at and pdated_at columns 
    //public $timestamps = false;
    protected $fillable = [
        'regNo',
        'course_id',
    ];

    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }

    public function student(){
        return $this->belongsTo(Student::class,'regNo');
    }

}
