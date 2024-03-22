<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $questions = [
            ['text' => 'What is the full form of DBMS?', 'difficulty' => 'easy'],
            ['text' => 'What is a database?', 'difficulty' => 'easy'],
            ['text' => 'What is DBMS?', 'difficulty' => 'easy'],
            ['text' => 'Who created the first DBMS?', 'difficulty' => 'medium'],
            ['text' => 'Which type of data can be stored in the database?', 'difficulty' => 'easy'],
            ['text' => 'In which of the following formats data is stored in the database management system?', 'difficulty' => 'easy'],
            ['text' => 'Which of the following is not a type of database?', 'difficulty' => 'medium'],
            ['text' => 'Which of the following is not an example of DBMS?', 'difficulty' => 'easy'],
            ['text' => 'Which of the following is not a feature of DBMS?', 'difficulty' => 'medium'],
            ['text' => 'Which of the following is a feature of the database?', 'difficulty' => 'medium'],
        ];

        foreach ($questions as $question) {
            DB::table('questions')->insert([
                'category_id' => 5,
                'text' => $question['text'],
                'difficulty' => $question['difficulty'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
