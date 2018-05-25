<?php

namespace App\Http\Controllers;

use App\subjects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\CorrelativeService;
use App\Services\CareerService;

class SubjectController extends Controller
{
    protected $correlativeService;
    protected $careerService;

    public function __construct(
        CorrelativeService $correlativeService,
        CareerService $careerService
    )
    {
        $this->middleware(\App\Http\Middleware\CheckTenant::class);
        $this->correlativeService = $correlativeService;
        $this->careerService = $careerService;
    }

    private function getIdCorrelatives($id_subject) {
        $result_correlatives = array();
        $correlatives = DB::table('correlatives')->where('correlatives.id_subject', '=', $id_subject)
            ->join('subjects', 'subjects.id', '=', 'correlatives.id_subject_dependence')
            ->select('subjects.id')
            ->get();

        foreach ($correlatives as $value) {
            $result_correlatives[] = $value->id;
        }
        return $result_correlatives;
    }

    private function getIdCorrelativesName($id_subject) {
        $result_correlatives = array();
        $correlatives = DB::table('correlatives')->where('correlatives.id_subject', '=', $id_subject)
            ->join('subjects', 'subjects.id', '=', 'correlatives.id_subject_dependence')
            ->select('subjects.name')
            ->get();

        foreach ($correlatives as $value) {
            $result_correlatives[] = $value->name;
        }
        return $result_correlatives;
    }

    private function getIdCareers($subject_id) {
        $result_careers = array();
        $careers = DB::table('careers_subjects')->where('careers_subjects.subject_id', '=', $subject_id)
            ->select('careers_subjects.career_id as id')
            ->get();

        foreach ($careers as $value) {
            $result_careers[] = $value->id;
        }
        return $result_careers;
    }

    private function getIdCareersName($subject_id) {
        $result_careers = array();
        $careers = DB::table('careers_subjects')->where('careers_subjects.subject_id', '=', $subject_id)
            ->join('careers', 'careers.id', '=', 'careers_subjects.career_id')
            ->select('careers.name')
            ->get();

        foreach ($careers as $value) {
            $result_careers[] = $value->name;
        }
        return $result_careers;
    }

    public function getCareers(Request $request) {
        $count = DB::table('careers_subjects')->where('careers_subjects.subject_id', '=', $request->input('subject_id'))
            ->count();
        return response(DB::table('careers_subjects')->where('careers_subjects.subject_id', '=', $request->input('subject_id'))
            ->join('careers', 'careers.id', '=', 'careers_subjects.career_id')
            ->select('careers.name', 'careers.id')
            ->get(), 200)->header('X-Total-Count', $count);
    }

    public function getCorrelatives(Request $request) {
        $count = DB::table('correlatives')->where('correlatives.id_subject', '=', $request->input('subject_id'))
            ->count();
        return response(DB::table('correlatives')->where('correlatives.id_subject', '=', $request->input('subject_id'))
            ->join('subjects', 'subjects.career_id', '=', 'correlatives.id_subject_dependence')
            ->select('subjects.name', 'subjects.id')
            ->get(), 200)->header('X-Total-Count', $count);
    }

    public function show($id)
    {
        $subjectDetail = subjects::find($id);
        $result = [
            'id'=>$subjectDetail->id,
            'name'=>$subjectDetail->name,
            'descripcion'=>$subjectDetail->description,
            'year'=>$subjectDetail->year,
            'workload'=>$subjectDetail->workload,
            'code'=>$subjectDetail->code,
            'promotable'=>$subjectDetail->promotable,
            'correlatives'=>$this->getIdCorrelatives($id),
            'correlativesName'=>$this->getIdCorrelativesName($id),
            'careersName'=>$this->getIdCareersName($id),


            'careers'=>$this->getIdCareers($id)
        ];
        return response($result, 200);
    }

    public function showAll(Request $request)
    {
        $sort = $request->input('_sort');
        $end = $request->input('_end');
        $start = $request->input('_start');
        $order = $request->input('_order');
        $result = DB::table('subjects')
            ->orderBy($sort, $order)
            ->offset($start)
            ->limit($end)
            ->get();

        $list = array_map(function($item) {
            $item->correlatives = $this->getIdCorrelatives($item->id);
            $item->correlativesName = $this->getIdCorrelativesName($item->id);
            $item->careers = $this->getIdCareers($item->id);
            $item->careersName = $this->getIdCareersName($item->id);
            return $item;
        }, $result->all());

        return response($list, 200)
            ->header('X-Total-Count', \App\subjects::all()->count());
    }

    public function delete($id) {
        $student = subjects::find($id);
        $student->delete();
        return response()->json(array('success' => true), 200);
    }

    public function edit($id) {
        $subject = subjects::find($id);

        $subjectData = json_decode(request()->getContent(), true);

        $subject->name = $subjectData['name'];
        $subject->description = $subjectData['description'];
        $subject->year = $subjectData['year'];
        $subject->workload = $subjectData['workload'];
        $subject->code = $subjectData['code'];
        $subject->promotable = $subjectData['promotable'];

        $this->correlativeService->store($id, $subjectData['correlatives']);
        $this->careerService->store($id, $subjectData['careers']);

        $subject->save();

        return response()->json(array('success' => true, 'id' => $subject->id), 200);

    }

    public function create(Request $request)
    {
        $subject = new subjects;
        $subjectData = json_decode(request()->getContent(), true);

        $subject->name = $subjectData['name'];
        $subject->description = $subjectData['description'];
        $subject->year = $subjectData['year'];
        $subject->workload = $subjectData['workload'];
        $subject->code = $subjectData['code'];
        $subject->promotable = $subjectData['promotable'];

        $subject->save();

        $id = $subject->id;

        $this->correlativeService->store($id, $subjectData['correlatives']);
        $this->careerService->store($id, $subjectData['career']);

        return response()->json(array('success' => true), 200);
    }
}
