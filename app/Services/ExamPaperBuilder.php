<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Support\Collection;

class ExamPaperBuilder
{
    /**
     * Question ids for one candidate's paper.
     *
     * $config is users.exam_config: {"total": N, "categories": {"<category_id>": count}}.
     * Without a config the legacy default paper is used.
     */
    public function questionIds(?array $config): Collection
    {
        if (empty($config['categories'])) {
            return $this->legacyDefault();
        }

        $ids = collect();
        foreach ($config['categories'] as $categoryId => $count) {
            $count = (int) $count;
            if ($count < 1) {
                continue;
            }

            $ids = $ids->merge(
                Question::where('category_id', $categoryId)->has('answers')->inRandomOrder()->limit($count)->pluck('id')
            );
        }

        return $ids->shuffle()->values();
    }

    /** Previous hard-coded paper: 10 English, 10 General Knowledge, 80 from the rest (Analytical excluded). */
    public function legacyDefault(): Collection
    {
        return Question::where('category_id', 4)->inRandomOrder()->limit(10)->pluck('id')
            ->merge(Question::where('category_id', 7)->inRandomOrder()->limit(10)->pluck('id'))
            ->merge(Question::whereNotIn('category_id', [4, 7, 14])->inRandomOrder()->limit(80)->pluck('id'))
            ->shuffle()
            ->values();
    }

    /** [category_id => number of usable questions] */
    public function availability(): array
    {
        return Question::has('answers')->selectRaw('category_id, count(*) as n')->groupBy('category_id')->pluck('n', 'category_id')->all();
    }
}
