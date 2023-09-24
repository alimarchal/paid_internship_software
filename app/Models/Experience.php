<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'organization',
        'designation',
        'government_private',
        'monthly_salary',
        'starting_date',
        'ending_date',
        'reason_of_leaving',
        'experience_photo_path',
        'relieving_letter_path',
    ];

}
