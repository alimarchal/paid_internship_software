<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'education_level',
        'board_university_name',
        'passing_year',
        'cgpa_cpa_grade',
        'total_marks_cgpa',
        'obtain_marks_cgpa',
        'division',
        'percentage_marks',
        'major_subject',
        'degree_photo_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
