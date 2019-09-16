<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\TaskBlock;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class TaskBlockController extends Controller
{
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
     * @return \Illuminate\Http\Response
     */
    public function create(Lesson $lesson)
    {
        $teacher = Auth::user();
        if($teacher->can('create', [TaskBlock::class, $lesson])){
            return view('lesson.TaskBlock.create', ['lesson' => $lesson]);
        }else {
            return redirect()
            ->route('lesson.edit', [$lesson->module_id, $lesson->id])
            ->with(['message'=>'Permisson denied']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Lesson $lesson)
    {
        $teacher = Auth::user();

        if($teacher->can('store', [TaskBlock::class, $lesson])){

            //dd($request);
            //create new lesson and assign serial_number automaticaly
            $taskBlock = TaskBlock::create($request->input());


            $taskBlock->lesson_id = $lesson->id;
            $taskBlock->position = TaskBlock::where('lesson_id', $lesson->id)->max('position') + 1;//make it be after the last added lesson
            $taskBlock->save();
            return redirect()->route('lesson.edit',[$lesson->module_id, $lesson->id]);
        }else{
            return redirect()
            ->route('lesson.edit', $lesson->module_id, $lesson->id)
            ->with(['message'=>'Permission denied']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson, TaskBlock $taskBlock)
    {
        return view('taskBlock.show', ['taskBlock' => $taskBlock, 'lesson' => $lesson]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson, TaskBlock $taskBlock)
    {
        $teacher = Auth::user();
        //dd($lesson, $course, $teacher);
        if($teacher->can('edit', [$taskBlock])){
            return view('taskBlock.edit', ['taskBlock' => $taskBlock, 'lesson' => $lesson]);
        }else return redirect()
        ->route('lesson.edit', [$lesson->module_id, $lesson->id])
        ->with(['message' => 'permission denied']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson, TaskBlock $taskBlock)
    {
        $teacher = Auth::user();
        if($teacher->can('update', [$taskBlock])){
            $taskBlock->update($request->input());
            $taskBlock->save();
            return redirect()->route('lesson.edit', [$lesson->module_id, $lesson->id]);
        }
        else return redirect()
        ->route('lesson.edit', [$lesson->module_id, $lesson->id])
        ->with(['message'=>'permission enied']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson, TaskBlock $taskBlock)
    {
        $teacher = Auth::user();
        if($teacher->can('destroy', [$taskBlock])){
            $taskBlock->delete();
            return redirect()->route('lesson.edit', [$lesson->module_id, $lesson->id]);
        } else return redirect()
        ->route('lesson.edit',[$lesson->module_id, $lesson->id])
        ->with(['message'=>'permission denied']);
    }
}