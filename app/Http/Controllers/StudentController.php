<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function index()
    {
        $students = StudentResource::collection(Student::with('class', 'section')->get());

        return Inertia::render('Students/Index', [
            'students' => $students
        ]);
    }
}
