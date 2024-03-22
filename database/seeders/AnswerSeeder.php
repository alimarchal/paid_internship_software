<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $answers = [
            // Answers for question 1
            ['question_id' => 1, 'text' => 'Data of Binary Management System', 'is_correct' => false],
            ['question_id' => 1, 'text' => 'Database Management System', 'is_correct' => true],
            ['question_id' => 1, 'text' => 'Database Management Service', 'is_correct' => false],
            ['question_id' => 1, 'text' => 'Data Backup Management System', 'is_correct' => false],

            // Continue pattern for remaining questions...
            // Answers for question 2
            ['question_id' => 2, 'text' => 'Organized collection of information that cannot be accessed, updated, and managed', 'is_correct' => false],
            ['question_id' => 2, 'text' => 'Collection of data or information without organizing', 'is_correct' => false],
            ['question_id' => 2, 'text' => 'Organized collection of data or information that can be accessed, updated, and managed', 'is_correct' => true],
            ['question_id' => 2, 'text' => 'Organized collection of data that cannot be updated', 'is_correct' => false],

            // This pattern is repeated for all questions...
            // Ensure 'is_correct' is only true for the correct answer.

            // Answers for question 3
            ['question_id' => 3, 'text' => 'DBMS is a collection of queries', 'is_correct' => false],
            ['question_id' => 3, 'text' => 'DBMS is a high-level language', 'is_correct' => false],
            ['question_id' => 3, 'text' => 'DBMS is a programming language', 'is_correct' => false],
            ['question_id' => 3, 'text' => 'DBMS stores, modifies and retrieves data', 'is_correct' => true],

            // Answers for question 4
            ['question_id' => 4, 'text' => 'Edgar Frank Codd', 'is_correct' => false],
            ['question_id' => 4, 'text' => 'Charles Bachman', 'is_correct' => true],
            ['question_id' => 4, 'text' => 'Charles Babbage', 'is_correct' => false],
            ['question_id' => 4, 'text' => 'Sharon B. Codd', 'is_correct' => false],

            // Answers for question 5
            ['question_id' => 5, 'text' => 'Image oriented data', 'is_correct' => false],
            ['question_id' => 5, 'text' => 'Text, files containing data', 'is_correct' => false],
            ['question_id' => 5, 'text' => 'Data in the form of audio or video', 'is_correct' => false],
            ['question_id' => 5, 'text' => 'All of the above', 'is_correct' => true],

            // Answers for question 6
            ['question_id' => 6, 'text' => 'Image', 'is_correct' => false],
            ['question_id' => 6, 'text' => 'Text', 'is_correct' => false],
            ['question_id' => 6, 'text' => 'Table', 'is_correct' => true],
            ['question_id' => 6, 'text' => 'Graph', 'is_correct' => false],

            // Answers for question 7
            ['question_id' => 7, 'text' => 'Hierarchical', 'is_correct' => false],
            ['question_id' => 7, 'text' => 'Network', 'is_correct' => false],
            ['question_id' => 7, 'text' => 'Distributed', 'is_correct' => false],
            ['question_id' => 7, 'text' => 'Decentralized', 'is_correct' => true],

            // Answers for question 8
            ['question_id' => 8, 'text' => 'MySQL', 'is_correct' => false],
            ['question_id' => 8, 'text' => 'Microsoft Access', 'is_correct' => false],
            ['question_id' => 8, 'text' => 'IBM DB2', 'is_correct' => false],
            ['question_id' => 8, 'text' => 'Google', 'is_correct' => true],

            // Answers for question 9
            ['question_id' => 9, 'text' => 'Minimum Duplication and Redundancy of Data', 'is_correct' => false],
            ['question_id' => 9, 'text' => 'High Level of Security', 'is_correct' => false],
            ['question_id' => 9, 'text' => 'Single-user Access only', 'is_correct' => true],
            ['question_id' => 9, 'text' => 'Support ACID Property', 'is_correct' => false],

            // Answers for question 10
            ['question_id' => 10, 'text' => 'No-backup for the data stored', 'is_correct' => false],
            ['question_id' => 10, 'text' => 'User interface provided', 'is_correct' => true],
            ['question_id' => 10, 'text' => 'Lack of Authentication', 'is_correct' => false],
            ['question_id' => 10, 'text' => 'Store data in multiple locations', 'is_correct' => false],
        ];

        foreach ($answers as $answer) {
            DB::table('answers')->insert([
                'question_id' => $answer['question_id'],
                'text' => $answer['text'],
                'is_correct' => $answer['is_correct'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
