<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;

class EnrrollService
{
    public function store($idCourse, $students)
    {
        if($idCourse) {
            foreach ($students as $student) {
                $enrrolls[] = array('course_id' => $idCourse, 'student_id' => $student);
            }
            DB::table('correlatives')->where('id_subject', $id_subject)->delete();
            DB::table('correlatives')->insert($correlatives);
        }
        return true;
    }

}
