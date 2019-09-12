<?php

namespace App\Http\Controllers;

use App\Course;
use App\Models\Module;
use App\Models\Lesson;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:teacher')->except('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function create(Module $module)
    {
        $teacher = Auth::user();
        if($teacher->can('create', [Lesson::class, $module])){
            return view('lesson.create', ['module' => $module]);
        }else {
            return redirect()
            ->route('course.show', $module->course_id)
            ->with(['message'=>'Permisson denied']);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Module $module)
    {
        $teacher = Auth::user();

        if($teacher->can('store', [Lesson::class, $module])){

            //dd($request);
            //create new lesson and assign serial_number automaticaly
            $lesson = Lesson::create($request->input());

            $lesson->slug = Str::slug($lesson->title);

            $lesson->module_id = $module->id;
            $lesson->position = Lesson::where('module_id', $lesson->module_id)->max('position') + 1;//make it be after the last added lesson
            $lesson->save();
            return redirect()->route('lesson.show',[$module->id, $lesson->id]);
        }
        else
        {
            return redirect()
            ->route('course.show', $module->course_id)
            ->with(['message'=>'Permission denied']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Lesson $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module, Lesson $lesson)
    {
        return view('lesson.show', ['lesson' => $lesson, 'module' => $module]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Course $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Module $module, Lesson $lesson)
    {
        $teacher = Auth::user();
        //dd($lesson, $course, $teacher);
        if($teacher->can('edit', [$lesson])){
            return view('lesson.edit', ['lesson' => $lesson, 'module' => $module]);
        }else return redirect()
        ->route('course.show', $module->course_id)
        ->with(['message' => 'permission denied']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Module $module, Lesson $lesson)
    {
        $teacher = Auth::user();
        if($teacher->can('update', [$lesson])){
            $lesson->update($request->except('slug'));
            $lesson->save();
            return redirect()->route('course.edit', [$module->course_id]);
        }
        else return redirect()
        ->route('course.edit', $module->course_id)
        ->with(['message'=>'permission enied']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module, Lesson $lesson)
    {
        $teacher = Auth::user();
        if($teacher->can('destroy', [$lesson])){
            $lesson->delete();
            return redirect()->route('course.edit', $module->course_id);
        } else return redirect()
        ->route('course.edit', $module->course_id)
        ->with(['message'=>'permission denied']);

    }
}
