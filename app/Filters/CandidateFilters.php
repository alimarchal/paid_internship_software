<?php

namespace App\Filters;

use Spatie\QueryBuilder\AllowedFilter;

/** filter[...] definitions shared by the candidate list and Batch Exam Setup (Spatie Query Builder). */
class CandidateFilters
{
    /** @return array<int, AllowedFilter> */
    public static function allowed(): array
    {
        return [

            AllowedFilter::exact('id'),
            AllowedFilter::partial('name'),
            AllowedFilter::partial('fathers_name'),
            AllowedFilter::partial('email'),
            AllowedFilter::partial('cnic_number'),
            AllowedFilter::partial('contact_number'),
            AllowedFilter::exact('batch_no'),
            AllowedFilter::exact('status'),
            AllowedFilter::exact('profile_status'),
            AllowedFilter::exact('gender'),
            AllowedFilter::exact('religion'),
            AllowedFilter::exact('marital_status'),
            AllowedFilter::exact('district'),
            AllowedFilter::exact('district_of_domicile'),
            // Values here may contain commas, which Query Builder would otherwise split into an array.
            AllowedFilter::callback('degree_level', fn ($q, $v) => $q->where('degree_level', is_array($v) ? implode(',', $v) : $v)),
            AllowedFilter::callback('test_center', fn ($q, $v) => $q->where('test_center', is_array($v) ? implode(',', $v) : $v)),
            AllowedFilter::exact('test_date'),
            AllowedFilter::exact('education_degrees_search.major_subject'),
            AllowedFilter::callback('exam_state', function ($q, $value) {
                match ($value) {
                    'not_allowed' => $q->where('start_test', 0),
                    'allowed' => $q->where('start_test', 1)->where('exam_taken', 0),
                    'finished' => $q->where('exam_taken', 1),
                    default => null,
                };
            }),
            AllowedFilter::callback('paper', function ($q, $value) {
                match ($value) {
                    'allocated' => $q->whereHas('randomQuestions'),
                    'not_allocated' => $q->whereDoesntHave('randomQuestions'),
                    'configured' => $q->whereNotNull('exam_config'),
                    default => null,
                };
            }),
            AllowedFilter::callback('applied_from', fn ($q, $v) => $q->whereDate('created_at', '>=', $v)),
            AllowedFilter::callback('applied_to', fn ($q, $v) => $q->whereDate('created_at', '<=', $v)),
            AllowedFilter::callback('search', function ($q, $value) {
                $value = is_array($value) ? implode(',', $value) : $value;
                $q->where(fn ($w) => $w->where('name', 'like', "%{$value}%")->orWhere('email', 'like', "%{$value}%")
                    ->orWhere('cnic_number', 'like', "%{$value}%")->orWhere('id', $value));
            }),

            AllowedFilter::exact('latestStatus.status'),
        ];
    }

    public static function sorts(): array
    {
        return ['id', 'name', 'created_at', 'batch_no', 'district_of_domicile', 'start_test_time'];
    }
}
