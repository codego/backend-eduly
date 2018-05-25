<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CareersSubjects extends Controller
{
    function __construct()
    {
        $this->middleware(\App\Http\Middleware\CheckTenant::class);
    }

    public function showFromSubject($id)
    {
        return response(DB::table('careers_subjects')->where('subject_id', $id)->get(), 200)
            ->header('X-Total-Count', \App\subjects::all()->count());
    }

    public function showFromCareer($id)
    {
        return response(DB::table('careers_subjects')->where('career_id', $id)->get(), 200)
            ->header('X-Total-Count', \App\subjects::all()->count());
    }
}
