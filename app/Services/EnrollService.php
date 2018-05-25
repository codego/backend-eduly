<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;

class EnrollService
{
    public function store($idCourse, $students)
    {
        if($idCourse) {
            foreach ($students as $student) {
                $enrolls[] = array('course_id' => $idCourse, 'student_id' => $student);
            }
            DB::table('student_course')->insert($enrolls);
        }
        return true;
    }

}
