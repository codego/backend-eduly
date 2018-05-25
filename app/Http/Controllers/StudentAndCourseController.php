<?php

namespace App\Http\Controllers;

use App\StudentAndCourse;
use Illuminate\Http\Request;
use App\students;
use Illuminate\Support\Facades\DB;
use App\Services\EnrollService;

class StudentAndCourseController extends Controller
{
    protected $student;

    protected $enrollService;

    function __construct(Students $student, EnrollService $enrollService)
    {
        $this->student = $student;
        $this->enrollService = $enrollService;
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sac = new StudentAndCourse();
        $sacData = json_decode(request()->getContent(), true);

        $sac->course_id = $sacData['id'];
        $sac->student_id = $sacData['student_id'];

        $sac->save();

        return response()->json(array('success' => true), 200);
    }

    public function enroll(Request $request) {
        $payload = json_decode(request()->getContent(), true);
        $this->enrollService->store($payload['courseId'], $payload['students']);

        return response()->json(array('success' => true), 200);
    }

    public function showFromCourse($id)
    {
        return response(DB::table('student_course')->where('course_id', $id)->get(), 200)
            ->header('X-Total-Count', \App\subjects::all()->count());
    }

    public function showFromStudent($id)
    {
        return response(DB::table('student_course')->where('student_id', $id)->get(), 200)
            ->header('X-Total-Count', \App\subjects::all()->count());
    }

    public function listStudentsInscribables(Request $request) {
        $cursoId = $request->input('course_id');
        $query = response(DB::table('students')->get(), 200)
                ->header('X-Total-Count', \App\students::all()->count());

        return $query;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
