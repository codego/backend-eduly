<?php

namespace App\Http\Controllers;

use App\teachers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TeachersController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    public function show($id)
    {
        //return new StudentsResource(Students::find($id));
        //return Students::where('id', $id)->get();
        //return response()->json(array('success' => true), 200);
        return teachers::find($id);

    }

    public function showAll(Request $request)
    {
        $sort = $request->input('_sort');
        $end = $request->input('_end');
        $start = $request->input('_start');
        $order = $request->input('_order');
        return response(DB::table('teachers')->orderBy($sort, $order)->offset($start)->limit($end)->get(), 200)
            ->header('X-Total-Count', \App\teachers::all()->count());
    }

    public function delete($id) {
        $student = teachers::find($id);
        $student->delete();
        return response()->json(array('success' => true), 200);
    }

    public function edit($id) {
        $student = teachers::find($id);

        $studentData = json_decode(request()->getContent(), true);

        $student->name = $studentData['name'];
        $student->lastname = $studentData['lastname'];
        $student->document = $studentData['document'];
        $student->gender = $studentData['gender'];
        $student->email = $studentData['email'];
        $student->status = $studentData['status'];
        $student->status = $studentData['phone'];
        $student->entry = date('Y-m-d H:i:s'); //$studentData['entry'];
        //$student->egress = $studentData['egress'];

        $student->save();
        return response()->json(array('success' => true, 'id' => $student->id), 200);


    }

    public function create(Request $request)
    {
        $teachers = new teachers;
        $studentData = json_decode(request()->getContent(), true);

        $student->name = $studentData['name'];
        $student->lastname = $studentData['lastname'];
        $student->document = $studentData['document'];
        $student->gender = $studentData['gender'];
        $student->email = $studentData['email'];
        $student->status = $studentData['status'];
        $student->status = $studentData['phone'];

        $teachers->save();
        return $teachers->id;
    }
}
