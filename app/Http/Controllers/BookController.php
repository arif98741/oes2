<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\eyb_subject;
use DB,Validator;
use App\eyb_question;
class BookController extends Controller
{
    public  function Index(Request $request)
    {
        $subject_id = isset($request->subject) ? $request->subject :  2;
        $level_id   = isset($request->level) ? $request->level :  1;
    	$data['levels'] 	   = DB::table('eyb_level')->where('user_id',1)->where('type',1)->get();
    	$data['subjects'] 	   = eyb_subject::where('user_id',1)->where('status',1)->get();
    	$data['level_id'] 	   = $level_id;
    	$data['subject_id']    = $subject_id;
        $subject               = eyb_subject::where('id',$subject_id)->first();
        $data['subject_name']  = $subject->subject_name;
    	$questions 	           = eyb_question::where('subject',$subject_id)->where('student_grade',$level_id)->paginate(50);
        $start = 1;
        if($questions->currentPage() > 1)
        {
                $start = (($questions->currentPage() - 1) * 50) + 1;
        }
        $data['questions']      = $questions;
    	$data['start']		    = $start;
    	$data['total_question'] = eyb_question::where('subject',$subject_id)->where('student_grade',$level_id)->count();
        if($request->ajax()){

            $view =  view('front-end.book.study-content',$data);
            $result['view']         = $view->render();
            $result['subject_name'] = $subject->subject_name;
            return response()->json(['success'=>$result]);  
        }
    	return view('front-end.book.index',$data);
    }

    public function filter_study(Request $request)
    {
    	$validator = Validator::make($request->all(), [

            'level'         => 'required|numeric'
           ]);
    	if ($validator->passes()) {
    		if(!isset($request->study) && !isset($request->page))
    		{
    			$subjects = eyb_subject::where('level_id',$request->level)->get();
    			$html = '<option value="">Select Subject</option>';
	            $subjects = eyb_subject::where('level_id',$request->level)->where('status',1)->get();
	            if(!empty($subjects))
	            {
	                foreach($subjects  as $subject)
	                {
	                    $html .= '<option value="'.$subject->id.'">'.$subject->subject_name.'</option>';
	                }
	            }
	            return response()->json(['success'=>$html]);
    		}
    		$validator = Validator::make($request->all(), [

            'level'         => 'required|numeric',
            'subject'       => 'required|numeric'
           ]);
    		if ($validator->passes()) {
    			$questions 	= eyb_question::where('subject',$request->subject)->where('student_grade',$request->level)->paginate(50);
                $subject = eyb_subject::where('id',$request->subject)->first();
    			$start = 1;
                if($questions->currentPage() > 1)
                {
                    $start = (($questions->currentPage() - 1) * 50) + 1;
                }
                $data['questions']      = $questions;
                $data['start']          = $start;
                $data['total_question'] = eyb_question::where('subject',$request->subject)->where('student_grade',$request->level)->count();
    			$view =  view('front-end.book.study-content', $data);
	    		$result['view']         = $view->render();
                $result['subject_name'] = $subject->subject_name;
    			return response()->json(['success'=>$result]);
    		}else{
    			return response()->json(['error'=>$validator->errors()->all()]);
    		}
    	}else{
    		return response()->json(['error'=>$validator->errors()->all()]);
    	}
    	
    }
    public function study_pagination(Request $request)
    {
    	$validator = Validator::make($request->all(), [

            'level'         => 'required|numeric',
            'subject'       => 'required|numeric'
           ]);
    	if ($validator->passes()) {

    		$url = url('/');
	    	$str = str_replace($url,'',$request->href);
	    	$str = str_replace('-','',$str);
	    	$int = (int) filter_var($str, FILTER_SANITIZE_NUMBER_INT);
	    	
	    	if(!is_numeric($int))
	    	{
	    		$error[0] = 'Please provide valid url!';
	    		return response()->json($error);
	    	}
	    	$page = $int;
	    	$limit = 50;
	    	$skip = 0;
	    	$prev = 1;
            $next = $page + 1;
	    	if($page > 1)
	    	{
	    		$skip = ($page - 1) * $limit;
	    		$prev = $page - 1;
	    	}
            $total_question = eyb_question::where('subject',$request->subject)->where('student_grade',$request->level)->count();
            $pag = ceil($total_question/$limit);
            if($next > $pag)
            {
                $next = $page;
            }
	    	$data['start'] = $skip +1;
	    	$data['questions'] 	= eyb_question::where('subject',$request->subject)->where('student_grade',$request->level)->skip($skip)->take($limit)->get();
	    	$view =  view('front-end.book.study-content', $data);
	    	$result['view']             = $view->render();
	    	$result['prev'] = $prev;
            $result['next'] = $next;
	    	return response()->json(['success'=>$result]);
    	}else{

    		return response()->json(['error'=>$validator->errors()->all()]);
    	}	
    }
}
