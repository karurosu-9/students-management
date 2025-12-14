<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Resources\ClassesResource;
use App\Http\Resources\StudentResource;
use App\Models\Classes;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function index()
    {
        $students = StudentResource::collection(Student::with('class', 'section')->paginate(10));

        return Inertia::render('Students/Index', [
            'students' => $students
        ]);
    }

    public function create()
    {
        // ResourceクラスでJSON化して全てのクラスを取得
        $classes = ClassesResource::collection(Classes::all());

        return Inertia::render('Students/Create', [
            'classes' => $classes,
        ]);
    }

    public function store(StoreStudentRequest $request)
    {
        Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id
        ]);

        return redirect(route('students.index'));
    }
}
