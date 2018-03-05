<?php

namespace App\Http\Controllers;

use App\students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class StudentsController extends Controller
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
        return Students::find($id);

    }

    public function showAll(Request $request)
    {
        $sort = $request->input('_sort');
        $end = $request->input('_end');
        $start = $request->input('_start');
        $order = $request->input('_order');
        return response(DB::table('students')->orderBy($sort, $order)->offset($start)->limit($end)->get(), 200)
                ->header('X-Total-Count', \App\students::all()->count());
    }

    public function delete($id) {
        $student = Students::find($id);
        $student->delete();
        return response()->json(array('success' => true), 200);
    }

    public function edit($id) {
        $student = Students::find($id);

        $studentData = json_decode(request()->getContent(), true);

        $student->name = $studentData['name'];
        $student->lastname = $studentData['lastname'];
        $student->document = $studentData['document'];
        $student->degree = $studentData['degree'];
        $student->gender = $studentData['gender'];
        $student->phone = $studentData['phone'];
        $student->address = $studentData['address'];
        $student->locality = $studentData['locality'];
        $student->city = $studentData['city'];
        $student->province = $studentData['province'];
        $student->place_birth = $studentData['place_birth'];
        $student->place_residence = $studentData['place_residence'];
        $student->email = $studentData['email'];
        $student->status = $studentData['status'];
        $student->entry = date('Y-m-d H:i:s'); //$studentData['entry'];
        //$student->egress = $studentData['egress'];

        $student->save();
        return response()->json(array('success' => true, 'id' => $student->id), 200);


    }

    public function create(Request $request)
    {
        $student = new Students;
        $studentData = json_decode(request()->getContent(), true);

        $student->name = $studentData['name'];
        $student->lastname = $studentData['lastname'];
        $student->document = $studentData['document'];
        $student->degree = $studentData['degree'];
        $student->gender = $studentData['gender'];
        $student->phone = $studentData['phone'];
        $student->address = $studentData['address'];
        $student->locality = $studentData['locality'];
        $student->city = $studentData['city'];
        $student->province = $studentData['province'];
        $student->place_birth = $studentData['place_birth'];
        $student->place_residence = $studentData['place_residence'];
        $student->email = $studentData['email'];
        $student->status = $studentData['status'];
        $student->entry = date('Y-m-d H:i:s'); //$studentData['entry'];
        //$student->egress = $studentData['egress'];

        $student->save();
        return $student->id;
    }
}
