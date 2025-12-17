<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoClassesSectionsStudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {

            // クラス作成
            $class = Classes::create([
                'name' => "Class {$i}",
            ]);

            // Section A / Section B を作成
            $sectionA = Section::create([
                'name'     => 'Section A',
                'class_id' => $class->id,
            ]);

            $sectionB = Section::create([
                'name'     => 'Section B',
                'class_id' => $class->id,
            ]);

            // Section A にランダム生徒5人
            Student::factory()
                ->count(5)
                ->create([
                    'class_id'   => $class->id,
                    'section_id' => $sectionA->id,
                ]);

            // Section B にランダム生徒5人
            Student::factory()
                ->count(5)
                ->create([
                    'class_id'   => $class->id,
                    'section_id' => $sectionB->id,
                ]);
        }
    }
}
