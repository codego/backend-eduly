<?php

namespace App\Http\Controllers;

use App\StudentAndCourse;
use Illuminate\Http\Request;
use App\students;
use Illuminate\Support\Facades\DB;
use App\Services\EnrollService;
use App\Services\CorrelativeService;
use App\Course;

class StudentAndCourseController extends Controller
{
    protected $student;

    protected $enrollService;

    protected $correlativeService;
    protected $course;

    function __construct(Students $student, EnrollService $enrollService, CorrelativeService $correlativeService, Course $course)
    {
        $this->student = $student;
        $this->course = $course;
        $this->enrollService = $enrollService;
        $this->correlativeService = $correlativeService;
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
         $course =  Course::find($cursoId);

        $correlatives = $this->correlativeService->getSubjectsCorrelatives($course->subject_id);
        $correlatives_ids = array();

        foreach ($correlatives as $correlative) {
            $correlatives_ids[] = $correlative->id_subject_dependence;
        }

        if(!empty($correlatives_ids)) {
            return response(
                    DB::table('student_course')
                        ->select('students.name', 'students.lastname', 'students.document', 'students.id')
                        ->whereIn('subject_id', $correlatives_ids)
                        ->where('approve', 1)
                        ->join('students', 'students.id', '=', 'student_course.student_id')
                        ->get(), 200)
                        ->header('X-Total-Count', \App\students::all()->count()
                );
        }

        return response(
            DB::table('students')
                ->select('id', 'name', 'lastname', 'document')
                ->get(), 200)
            ->header('X-Total-Count', \App\students::all()->count()
            );
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
