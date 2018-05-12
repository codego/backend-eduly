<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;

class CareerService
{
    public function store($subject_id, $careers_id)
    {
        if($subject_id) {
            foreach ($careers_id as $career_id) {
                $career_subject[] = array('career_id' => $career_id, 'subject_id' => $subject_id);
            }
            DB::table('careers_subjects')->where('subject_id', $subject_id)->delete();
            DB::table('careers_subjects')->insert($career_subject);
        }
        return true;
    }

}
