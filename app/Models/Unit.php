<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $table = 'units';
    protected $fillable = [
        'unit_id',
        'unit_name',
        'course_id',
        'unit_description',
        
    ];

    //relationships
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function mark()
    {
        return $this->hasOne(Mark::class, 'unit_id', 'unit_id');
    }
}
