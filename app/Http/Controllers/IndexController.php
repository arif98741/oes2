<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\eyb_users;
use App\Institute;
use App\eyb_module;
use App\eyb_question;
use App\eyb_student_answer;
use App\eyb_subject;
use DB;
class IndexController extends Controller
{
    public function index()
    {
    	$total = eyb_student_answer::select([
                'exam_date',
                DB::raw("count(id) as id"),
            ])->groupBy('exam_date')->orderBy('created_at','ASC')->take(10)->get();
    	$date = array();
        // echo '<pre>';
        // print_r($total);
        // die;
    	$id_count = array();
    	foreach($total as $key=>$item)
    	{
    		$date[] 	=date('M',strtotime($item->exam_date));
            
    		$id_count[] = $item->id;
    		
    	}
        $modules_query = DB::table('eyb_student_answers')
                            ->leftJoin('eyb_users', 'eyb_student_answers.student_id', '=', 'eyb_users.id')
                            ->select('eyb_student_answers.student_mark','eyb_users.name','eyb_users.image',DB::raw('MAX(student_mark) as student_mark'))
                            ->where('eyb_student_answers.created_at','like','%'.date('Y-m').'%')
                            ->groupBy('eyb_student_answers.student_id')
                            // ->orderBy('eyb_student_answers.student_mark', 'asc')
                            ->take(10)
                            ->get();
        
        $marks = array();
        $std_name = array();
        foreach ($modules_query as $key => $value) {
            $marks[]    = $value->student_mark;
            $name = explode(" ",$value->name);
            $std_name[] = $name[0];
        }
        
    	$data['m_h_users']  = $modules_query;
        $data['marks']      = $marks;
        $data['std_name']   = $std_name;
        $data['date']       = $date;
    	$data['ids']        = $id_count;
        
        $data['students']   = eyb_users::where('user_type',3)->count('id');
        $data['questions']  = eyb_question::count('id');
        $data['institutes'] = Institute::count('id');
        $data['subjects']   = eyb_subject::where('status',1)->count('id');
        $data['modules']    = eyb_module::count('id');

        return view('front-end.home',$data);
    }

    public function how_to_use()
    {
        return view('front-end.use');
    }
}
