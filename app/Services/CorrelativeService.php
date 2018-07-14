<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;

class CorrelativeService
{
    public function store($id_subject, $ids_subjects_dependences)
    {
        if($id_subject) {
            foreach ($ids_subjects_dependences as $id_subject_dependence) {
                $correlatives[] = array('id_subject' => $id_subject, 'id_subject_dependence' => $id_subject_dependence);
            }
            DB::table('correlatives')->where('id_subject', $id_subject)->delete();
            DB::table('correlatives')->insert($correlatives);
        }
        return true;
    }

    public function getSubjectsCorrelatives($id_subject) {
        return DB::table('correlatives')->where('id_subject', $id_subject)->select('id_subject_dependence')->get();
    }
}
