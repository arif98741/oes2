<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\StudentBatch;
class BatchController extends Controller
{
    public function manage_batch(Request $request)
    {
    	$admin_id  = admin_id();
        if ($request->isMethod('post')) {
            $validatedData = $request->validate([
                'level_id' 		=> 'required',
                'batch_name' 	=> 'required',
                'start_date'    => 'required',
                'end_date'    => 'required',
            ]);

            $batch = new StudentBatch();
            $batch->batch_name 	= $request->batch_name;
            $batch->user_id 	= $admin_id;
            $batch->level_id 	= $request->level_id;
            $batch->start_date  = date('Y-m-d',strtotime($request->start_date));
            $batch->end_date    = date('Y-m-d',strtotime($request->end_date));
            $batch->save();
            return redirect()->route('manage_batch')->with('success','Successfully added Subject.');
        }
        $batches = DB::table('student_batches')
                        ->leftJoin('eyb_level', 'student_batches.level_id', '=', 'eyb_level.id')
                        ->select('student_batches.*','eyb_level.level_name')
                        ->where('student_batches.user_id',$admin_id)
                        ->get();
        $levels = DB::table('eyb_level')->where('user_id',$admin_id)->get();
        return view('admin.batch.manage-batch',['batches'=>$batches,'levels'=>$levels]);
    }
    public function editBatch($id)
    {
        $admin_id   = admin_id();
        $batch    = DB::table('student_batches')->where('user_id',$admin_id)->where('id',$id)->first();
        $levels     = DB::table('eyb_level')->where('user_id',$admin_id)->get();
        return view('admin.batch.edit-batch',['batch'=>$batch,'levels'=>$levels]);
    }
    public function updateBatch(Request $request,$id)
    {
        $admin_id       = admin_id();

        $validatedData = $request->validate([
            'level_id' 		=> 'required',
            'batch_name'  	=> 'required',
        ]);
        $data = array();
        $batch = StudentBatch::where('id',$id)->where('user_id',$admin_id)->first();
        $batch->batch_name 	= $request->batch_name;
        $batch->user_id 	= $admin_id;
        $batch->level_id 	= $request->level_id;
        $batch->start_date  = date('Y-m-d',strtotime($request->start_date));
        $batch->end_date    = date('Y-m-d',strtotime($request->end_date));
        $batch->update();
        return redirect()->back()->with('success','Subject Updated Successfully!');
    }
    public function deleteBatch(Request $request)
    {
        $id = $request->id;
        $admin_id       = admin_id();
        if(StudentBatch::where('id',$id)->where('user_id',$admin_id)->delete())
        {
            echo 1;
        }else
        {
            echo 0;
        }
    }
}
