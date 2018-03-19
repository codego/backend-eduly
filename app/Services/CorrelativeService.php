<?php

namespace App\Services;

use App\correlatives;
use Illuminate\Support\Facades\DB;

class CorrelativeService
{
    public function store($id_subject, $ids_subjects_dependences)
    {
        var_dump($ids_subjects_dependences);
        foreach ($ids_subjects_dependences as $id_subject_dependence) {
            echo $id_subject_dependence->id_subject;
        }
        dd();
        /*
        if($id_subject) {
            foreach ($ids_subjects_dependences as $id_subject_dependence) {
                $correlatives[] = array('id_subject' => $id_subject, 'id_subject_dependence' => $id_subject_dependence);
            }
            DB::table('correlatives')->whereIn('id_subject', $id_subject)->delete();
            DB::table('correlatives')->insert($correlatives);
        }
        */
        return true;
    }
}
