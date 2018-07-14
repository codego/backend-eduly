<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DateTime;
use App\Services\CalendarService;

class CourseController extends Controller
{
    protected $calendarService;

    function __construct(CalendarService $calendarService)
    {
        $this->enrollService = $calendarService;
    }

    private function getStudents($id) {
        $result_students = array();
        $students = DB::table('student_course')->where('student_course.course_id', '=', $id)
            ->join('students', 'students.id', '=', 'student_course.student_id')
            ->select('students.id', 'students.name', 'students.lastname', 'students.document', 'student_course.updated_at')
            ->get();

        return $students;
    }

    private function getCalendar($id) {
        $result_calendar = array();
        $calendarSql = DB::table('calendar_courses')->where('calendar_courses.course_id', '=', $id)
            ->select('course_id', 'day_week as day', 'hour_init as hour_start', 'hour_finish as hour_end', 'periodicity')
            ->get();

        foreach ($calendarSql as $value) {
            if($value->hour_start) {
                $nuevaFecha = new DateTime($value->hour_start);
                $nuevaFecha->format('Y-m-d\TH:i:s.u');
                $value->hour_start = $nuevaFecha->format('Y-m-d\TH:i:s.u');
            }
            if($value->hour_end) {
                $nuevaFecha = new DateTime($value->hour_end);

                $value->hour_end = $nuevaFecha->format('Y-m-d\TH:i:s.u');
            }
            $result_calendar[] = $value;
        }
        return $result_calendar;
    }
    /**
     * Display a listing of the resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->input('_sort');
        $end = $request->input('_end');
        $start = $request->input('_start');
        $order = $request->input('_order');

        $result = DB::table('courses')->orderBy($sort, $order)->offset($start)->limit($end)->get();
        $list = array_map(function($item) {
            $item->calendar = $this->getCalendar($item->id);
            return $item;
        }, $result->all());

        return response($list, 200)
            ->header('X-Total-Count', \App\subjects::all()->count());

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
        $course = new Course();
        $courseData = json_decode(request()->getContent(), true);

        $course->init = $courseData['init'];
        $course->finish = $courseData['finish'];
        $course->subject_id = $courseData['subject_id'];
        $course->teacher_id = $courseData['teacher_id'];
        $course->group_by = $courseData['group_by'];
        $course->term = $courseData['term'];

        $course->save();

        $id = $course->id;
        $this->calendarService->store($id, $courseData['calendar']);

        return response()->json(array('success' => true), 200);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $courseDetail = Course::find($id);

        $result = [
            'id'=>$courseDetail->id,
            'init'=>$courseDetail->init,
            'finish'=>$courseDetail->finish,
            'subject_id'=>$courseDetail->subject_id,
            'teacher_id'=>$courseDetail->teacher_id,
            'group_by'=>$courseDetail->group_by,
            'term'=>$courseDetail->term,
            'calendar'=>$this->getCalendar($id),
            'enrolled_students'=>$this->getStudents($id),
        ];
        return response($result, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $course = Course::find($id);
        $courseData = json_decode(request()->getContent(), true);

        $course->init = $courseData['init'];
        $course->finish = $courseData['finish'];
        $course->subject_id = $courseData['subject_id'];
        $course->teacher_id = $courseData['teacher_id'];
        $course->group_by = $courseData['group_by'];
        $course->term = $courseData['term'];

        $course->save();

        $this->calendarService->store($id, $courseData['calendar']);

        return response()->json(array('success' => true, 'id' => $course->id), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::find($id);
        $course->delete();
        return response()->json(array('success' => true), 200);
    }
}
