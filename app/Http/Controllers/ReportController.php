<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\Report as ResourcesReport;
use App\Models\Post;
use Illuminate\Http\Resources\Json\ResourceResponse;
use Illuminate\Support\Facades\Auth;
use Validator;

class ReportController extends BaseController
{

    public function index()
    {
        $report = Report::all();
        $message = [];
        if (!$report) {
            return $this->sendError('there is no report',$message);
        }

        return $this->sendResponse(ResourcesReport::collection($report),'report retrieved successfully!');
    }



    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'description'=>'required',
            'post_id'=>'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('validate Error',$validator->errors());
        }

        $user = Auth::user();
        $input['user_id']=$user->id;
        $report = Report::create($input);
        return $this->sendResponse(new ResourcesReport($report),'Report created successfully!');
    }


    public function show($id)
    {
        $message = [];
        if (!Report::where('post_id',$id)->first()) {
            return $this->sendError('there is no report on this post',$message);
        }
        $report = Report::where('post_id',$id)->get();
        return $this->sendResponse(ResourcesReport::collection($report),'Report on this post retrieved successfully!');

    }


    public function update(Request $request, Report $report)
    {
        // $input = $request->all();
        $this->validate($request,[
            'processed'=>'required'
        ]);
        $report['processed']=$request->processed;
        $report->save();
        return $this->sendResponse(new ResourcesReport($report),'The report has been viewed');
    }

    public function destroy(Report $report)
    {
        $message = [];

        $report->delete();
        return $this->sendResponse(new ResourcesReport($report),'report deleted successfully!');
    }
}
