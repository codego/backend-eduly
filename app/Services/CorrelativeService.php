<?php

namespace App\Services;

use App\correlatives;
use Illuminate\Support\Facades\DB;

class CorrelativeService
{
    public function store($id_subject, $ids_subjects_dependences)
    {
        DB::table('correlatives')->whereIn('id_subject', $id_subject)->delete();
        var_dump($ids_subjects_dependences);
        dd();
    }
}