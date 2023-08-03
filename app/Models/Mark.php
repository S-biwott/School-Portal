<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;
    protected $table = 'marks';
    protected $fillable = [
        'regNo',
        'unit_id',
        'cat1',
        'cat2',
        'exam',
        'total_marks',
        'grade',
        
    ];

//relationships
    public function student(){
        return $this->belongsTo(Student::class);
    }
    public function unit(){
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
    }

}
