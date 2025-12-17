<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\ClassesResource;
use App\Http\Resources\StudentResource;
use App\Models\Classes;
use App\Models\Student;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $searchWord = $request->search;
        $classId = $request->class_id;

        $students = Student::searchCustomers($searchWord)               // 検索ワードでの絞り込みを行う
                        ->when($classId, function ($q) use ($classId) { // class_idでの絞り込みを行う
                            $q->where('class_id', $classId);
                        })
                        ->with('class', 'section')
                        ->select('id', 'name', 'email', 'class_id', 'section_id', 'created_at')
                        ->orderBy('id', 'asc')
                        ->paginate(10)
                        ->withQueryString(); // withQueryString()で、検索結果の維持などを行う

        $classes = Classes::all();

        return Inertia::render('Students/Index', [
            'students' => StudentResource::collection($students),
            'classes' => ClassesResource::collection($classes),
            'filters' => [
                'search' => $searchWord,
                'class_id' => $classId
            ]
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

        return redirect(route('students.index'))->with([
            'status' => 'success',
            'message' => '登録が完了しました。'
        ]);
    }

    public function edit(Student $student)
    {
        $classes = ClassesResource::collection(Classes::all());

        $student->load('class', 'section');

        return Inertia::render('Students/Edit',[
            'classes' => $classes,
            'student' => StudentResource::make($student) // 複数件のStudentsのデータであれば、StudentResource::collection()を使用する ※今回は1件のデータなのでmake()
        ]);
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $student->name = $request->name;
        $student->email = $request->email;
        $student->class_id = $request->class_id;
        $student->section_id = $request->section_id;
        $student->save();

        return redirect(route('students.index'))->with([
            'status' => 'success',
            'message' => '更新が完了しました。'
        ]);;
    }

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect(route('students.index'))->with([
            'status' => 'delete',
            'message' => '削除が完了しました。'
        ]);
    }
}
