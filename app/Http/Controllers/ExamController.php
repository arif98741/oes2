<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Validator;
use App\eyb_users;
use App\eyb_module;
use App\eyb_question;
use App\InstituteStudent;
use App\eyb_student_answer;
use App\StartModule;
use PDF;
class ExamController extends Controller
{
    public function Exam()
    {
        return view('front-end.exam.exam');
    }
    public function get_user()
    {
        // $get_session = session('user_id');
        // $user = DB::table('eyb_users')
        //             ->where('log',$get_session)
        //             ->first();
        // $user_id = $user->id;
        return session('user_id');
    }
    public function answet_downlaod($ans_id)
    {
        $user_id = user_id();
        $answer = eyb_student_answer::where('student_id',$user_id)->where('id',$ans_id)->first();
        $error['error']      = false;
        $error['message']    = 'refresh the page and try again.';
        if($answer != false)
        {

            $data['total_mark']     = $answer->module_mark;
            $data['obtain_mark']    = $answer->student_mark;  
            $std_ans = json_decode($answer->student_answer);
            $questions = array();
            foreach($std_ans as $key=>$ans)
            {
                $question = eyb_question::where('id',$ans->question_id)->first();
                $questions[$key] = $question;
                $questions[$key]['std_answer']   = json_decode($ans->student_ans);
                $questions[$key]['ans_is_right'] = $ans->ans_is_right;
            }
            $data['questions']      = $questions;
            $data['institute'] = DB::table('eyb_modules')
                                ->leftJoin('eyb_subjects','eyb_modules.subject','eyb_subjects.id')
                                ->leftJoin('eyb_level','eyb_modules.student_grade','eyb_level.id')
                                ->leftJoin('eyb_users','eyb_modules.user_id','eyb_users.id')
                                ->select('eyb_modules.module_name','eyb_modules.user_type','eyb_subjects.subject_name','eyb_level.level_name','eyb_users.name')
                                ->where('eyb_modules.id',$answer->module_id)
                                ->first();
        $fileName =  time().'.'. 'pdf' ;
        $pdf = PDF::loadView('front-end.exam.pdf', $data);
        return $pdf->download($fileName);
            // $view =  view('front-end.exam.pdf',$data);    
            // $error['view']          = $view->render();
            // $error['error']         = false;
            // $error['message']       = '';
           
            
        }
        return response()->json($error);
        
    }
    public function SingleModule($module_id){
        $module     = DB::table('eyb_modules')
                        ->where('id',$module_id)
                        ->first();
        return $module;
    }
    public function print($data)
    {
        echo '<pre>';
        print_r($data);
        die;
    }
    public function module_time_set($module)
    {
        
        $exam_time_second = $module->exam_end - $module->exam_time;
        if(session()->has('exam_module_id'))
        {
            //  Session::put('exam_end_time',$module->exam_end);
            //         Session::put('exam_start_time',$module->exam_time);
            //         Session::put('exam_module_id',$module->id);
            $se_m_id = session('exam_module_id');

            if($se_m_id != $module->id)
            {
                session()->forget('exam_end_time');
                session()->forget('exam_start_time');
                session()->forget('exam_module_id');

                if($exam_time_second != 0)
                {
                    //$exam_time = $exam_time_second/60;
                    Session::put('exam_end_time',$module->exam_end);
                    Session::put('exam_start_time',$module->exam_time);
                    Session::put('exam_module_id',$module->id);
                }
            }else{
            
               session()->forget('exam_end_time');
               session()->forget('exam_start_time');
               session()->forget('exam_module_id');
               if($exam_time_second != 0)
                {
                    //$exam_time = $exam_time_second/60;
                    Session::put('exam_end_time',$module->exam_end);
                    Session::put('exam_start_time',$module->exam_time);
                    Session::put('exam_module_id',$module->id);
                }

            }
        }else{

            if($exam_time_second != 0)
            {
                //$exam_time = $exam_time_second/60;
                Session::put('exam_end_time',$module->exam_end);
                Session::put('exam_start_time',$module->exam_time);
                Session::put('exam_module_id',$module->id);
            }
        }
    }
    public function set_module_start_time($module)
    {
        $ex = StartModule::where('std_id',user_id())->where('module_id',$module->id)->first();
        if($ex == false)
        {
            $add = new StartModule();
            $add->std_id = user_id();
            $add->module_id = $module->id;
            $add->start_time = time();
            $add->save();
        }
    }

    public function student_examination($module_id){
       
        if(!is_numeric($module_id))
        {
            return redirect()->route('module');
        }
        $data = array();
        $module     = $this->SingleModule($module_id);
        
        
        if(!empty($module))
        {
            if($module->module_type == 2)
            {
                $std_module = DB::table('eyb_student_answers')
                            ->select('module_id')
                            ->where('student_id',user_id())
                            ->where('module_type',2)
                            ->get();
                $json  = json_encode($std_module);
                $array = json_decode($json, true);
                $ex_m = DB::table('eyb_modules')
                        ->where('id',$module->id)
                        ->whereNotIn('eyb_modules.id', array_column($array, 'module_id'))
                        ->first();
                if($ex_m == false)
                {
                    return redirect()->back();
                }
            }
            if($module->exam_end_time != 0)
            {
                if($module->exam_end_time < time())
                {
                    return redirect()->back();
                }
            }
            if($module->exam_end_time != 0 && $module->exam_end_time != 0 && $module->exam_end_time != 0)
            {
                $this->set_module_start_time($module);
            }
            $order = json_decode($module->question_order);
            $data['questions']  = eyb_question::findMany($order);
            $data['module']     = $module;
            $data['institute'] = DB::table('eyb_modules')
                                ->leftJoin('eyb_subjects','eyb_modules.subject','eyb_subjects.id')
                                ->leftJoin('eyb_level','eyb_modules.student_grade','eyb_level.id')
                                ->leftJoin('eyb_users','eyb_modules.user_id','eyb_users.id')
                                ->select('eyb_modules.module_name','eyb_modules.user_type','eyb_subjects.subject_name','eyb_level.level_name','eyb_users.name')
                                ->where('eyb_modules.id',$module_id)
                                ->first();
            $data['total_mark'] = Db::table('eyb_questions')->whereIn('id', $order)->sum('mark');
            
            return view('front-end.exam.examination', $data);
        }else{
            return redirect()->route('module');
        }
    }
    public function student_examination_old($module_id){
       
        if(!is_numeric($module_id))
        {
            return redirect()->route('module');
        }
        $data = array();
        $module     = $this->SingleModule($module_id);
        
        if(!empty($module))
        {
            if($module->module_type == 2)
            {
                if($module->exam_end < time())
                {
                    return redirect()->route('student_score');
                }
                $eyb_student_answer = eyb_student_answer::where('student_id',user_id())->where('module_id', $module_id)->where('module_type',$module->module_type)->first();
                if($eyb_student_answer != false)
                {
                    return redirect()->route('student_score');
                }
            }

            if($module->module_type == 2)
            {
                $this->module_time_set($module);
            }
            $order = json_decode($module->question_order);
            $data['questions']  = eyb_question::findMany($order);
            $data['module']     = $module;
            $data['institute'] = DB::table('eyb_modules')
                                ->leftJoin('eyb_subjects','eyb_modules.subject','eyb_subjects.id')
                                ->leftJoin('eyb_level','eyb_modules.student_grade','eyb_level.id')
                                ->leftJoin('eyb_users','eyb_modules.user_id','eyb_users.id')
                                ->select('eyb_modules.module_name','eyb_modules.user_type','eyb_subjects.subject_name','eyb_level.level_name','eyb_users.name')
                                ->where('eyb_modules.id',$module_id)
                                ->first();
            $data['total_mark'] = Db::table('eyb_questions')->whereIn('id', $order)->sum('mark');
            
            return view('front-end.exam.examination', $data);
        }else{
            return redirect()->route('module');
        }
    }
    public function answer_submit(Request $request,$module_id)
    {
        $error['error']   = false; 
        $error['ex']   = false; 
        $error['message'] = ''; 
        if(!is_numeric($module_id))
        {   $error['error']   = true;
            $error['ex']   = false; 
            $error['message'] = 'Moule id invalid!'; 
            return response()->json($error);
        }
        $module     = $this->SingleModule($module_id);
        if(!empty($module))
        {
            if($module->module_type == 2)
            {
                $std_module = DB::table('eyb_student_answers')
                            ->where('student_id',user_id())
                            ->where('module_id',$module_id)
                            ->first();
                if($std_module != false)
                {
                    $error['error']     = true;
                    $error['ex']        = true; 
                    $error['message'] = 'You have already finished this examination!';
                    $error['route'] = route('student_score');
                   
                    return response()->json($error);
                }
            }
            $answer_questions = array();
            $order = json_decode($module->question_order);
            $questions  = eyb_question::findMany($order);
            $total_mark = Db::table('eyb_questions')->whereIn('id', $order)->sum('mark');
            $count       = 1;
            $obtain_mark = 0;
            $ans_array   = array();
            foreach($questions as $key=>$question)
            {
                
                $answer_questions[$key] = $question;
                $q_name = 'answer_'.$count;
                $ans_is_right = 'null';
                $std_answer = '';
                $mark = 0;
                if(isset($request->$q_name))
                {
                    $std_answer = $request->$q_name;
                    $answer_questions[$key]['std_answer'] = $std_answer;
                    $question_type_f    = 'question_type_'.$question->question_type;
                    $ans_is_right       = $this->$question_type_f($question,$std_answer);
                    $mark               = $question->mark;
                    if($ans_is_right == 'wrong')
                    {
                        $obtain_mark = $obtain_mark - $module->negative_mark;
                        $mark = 0;
                    }else{
                        $obtain_mark = $obtain_mark + $mark;
                    }
                    $answer_questions[$key]['ans_is_right'] = $ans_is_right;
                }else{
                    $obtain_mark = $obtain_mark + 0;
                    $answer_questions[$key]['std_answer'] = '';
                    $answer_questions[$key]['ans_is_right'] = '';
                }
                $ans_array[$key]['question_order_id']       = $key;
                $ans_array[$key]['module_type']             = $module->module_type;
                $ans_array[$key]['module_id']               = $module_id;
                $ans_array[$key]['question_id']             = $question->id;
                $ans_array[$key]['student_ans']             = json_encode($std_answer);
                $ans_array[$key]['student_taken_time']      = '';
                $ans_array[$key]['student_question_marks']  = $question->mark;
                $ans_array[$key]['student_marks']           = $mark;
                $ans_array[$key]['ans_is_right']            = $ans_is_right;
                $count++;

            }
            $eyb_student_answer = eyb_student_answer::where('student_id',user_id())->where('module_id', $module_id)->where('module_type',$module->module_type)->first();
            $ex = StartModule::where('std_id',user_id())->where('module_id',$module->id)->first();
            if($eyb_student_answer != false)
            {
                $eyb_student_answer->module_mark    = $total_mark;
                $eyb_student_answer->student_mark   = $obtain_mark;
                $eyb_student_answer->student_answer = json_encode($ans_array);
                $eyb_student_answer->update();
            }else{
                $eyb_student_answer = new eyb_student_answer();
                $eyb_student_answer->student_id     = user_id();
                if($module->user_type != 1)
                {
                    $inst_info  = InstituteStudent::where('user_id',user_id())->first();
                    $eyb_student_answer->level_id   = $inst_info->level;
                }else{
                    $eyb_student_answer->level_id   = 0;
                }
                
                $eyb_student_answer->module_id      = $module_id;
                $eyb_student_answer->subject_id     = $module->subject;
                $eyb_student_answer->module_type    = $module->module_type;
                $eyb_student_answer->user_id        = $module->user_id;
                $eyb_student_answer->module_time    = $module->exam_time;
                if($ex != false)
                {
                    $eyb_student_answer->start_time     = $ex->start_time;
                }
                $eyb_student_answer->ans_time       = time();
                $eyb_student_answer->module_mark    = $total_mark;
                $eyb_student_answer->student_mark   = $obtain_mark;
                $eyb_student_answer->student_answer = json_encode($ans_array);
                $eyb_student_answer->exam_date      = date('Y-m');
                $eyb_student_answer->save();
            }
            if($ex != false)
            {
                $ex->delete();
            }
            
            $error['error']   = false; 
            $error['message'] = 'Your examination has been successfully completed.';
            $error['route'] = route('show_examination_answer',$eyb_student_answer->id);
            return response()->json($error);
        }else{
            $error['error']   = true; 
            $error['message'] = 'Moule id invalid!'; 
            return response()->json($error);
        }
    }
    public function answer_submit_old(Request $request,$module_id)
    {
        $error['error']   = false; 
        $error['message'] = ''; 
        if(!is_numeric($module_id))
        {   $error['error']   = true; 
            $error['message'] = 'Moule id invalid!'; 
            return response()->json($error);
        }
        $module     = $this->SingleModule($module_id);
        if(!empty($module))
        {
            $answer_questions = array();
            $order = json_decode($module->question_order);
            $questions  = eyb_question::findMany($order);
            $total_mark = Db::table('eyb_questions')->whereIn('id', $order)->sum('mark');
            $count       = 1;
            $obtain_mark = 0;
            $ans_array   = array();
            foreach($questions as $key=>$question)
            {
                
                $answer_questions[$key] = $question;
                $q_name = 'answer_'.$count;
                $ans_is_right = 'null';
                $std_answer = '';
                $mark = 0;
                if(isset($request->$q_name))
                {
                    $std_answer = $request->$q_name;
                    $answer_questions[$key]['std_answer'] = $std_answer;
                    $question_type_f    = 'question_type_'.$question->question_type;
                    $ans_is_right       = $this->$question_type_f($question,$std_answer);
                    $mark               = $question->mark;
                    if($ans_is_right == 'wrong')
                    {
                        $obtain_mark = $obtain_mark - $module->negative_mark;
                        $mark = 0;
                    }else{
                        $obtain_mark = $obtain_mark + $mark;
                    }
                    $answer_questions[$key]['ans_is_right'] = $ans_is_right;
                }else{
                    $obtain_mark = $obtain_mark + 0;
                    $answer_questions[$key]['std_answer'] = '';
                    $answer_questions[$key]['ans_is_right'] = '';
                }
                $ans_array[$key]['question_order_id']       = $key;
                $ans_array[$key]['module_type']             = $module->module_type;
                $ans_array[$key]['module_id']               = $module_id;
                $ans_array[$key]['question_id']             = $question->id;
                $ans_array[$key]['student_ans']             = json_encode($std_answer);
                $ans_array[$key]['student_taken_time']      = '';
                $ans_array[$key]['student_question_marks']  = $question->mark;
                $ans_array[$key]['student_marks']           = $mark;
                $ans_array[$key]['ans_is_right']            = $ans_is_right;
                $count++;

            }
            // $data['questions']      = $answer_questions;
            // $data['total_mark']     = $total_mark;
            // $data['obtain_mark']    = $obtain_mark;
            // echo '<pre>';
            // print_r($data);
            // die;
            // $view =  view('front-end.exam.answer-content', $data);    
            // $error['view']          = $view->render();
            
            
            $eyb_student_answer = eyb_student_answer::where('student_id',user_id())->where('module_id', $module_id)->where('module_type',$module->module_type)->first();

            if($eyb_student_answer != false)
            {
                $eyb_student_answer->module_mark    = $total_mark;
                $eyb_student_answer->student_mark   = $obtain_mark;
                $eyb_student_answer->student_answer = json_encode($ans_array);
                $eyb_student_answer->update();
            }else{
                $eyb_student_answer = new eyb_student_answer();
                $eyb_student_answer->student_id     = user_id();
                if($module->user_type != 1)
                {
                    $inst_info  = InstituteStudent::where('user_id',user_id())->first();
                    $eyb_student_answer->level_id   = $inst_info->level;
                }else{
                    $eyb_student_answer->level_id   = 0;
                }
                
                $eyb_student_answer->module_id      = $module_id;
                $eyb_student_answer->subject_id     = $module->subject;
                $eyb_student_answer->module_type    = $module->module_type;
                $eyb_student_answer->user_id        = $module->user_id;
                $eyb_student_answer->module_time    = $module->exam_time;
                $eyb_student_answer->ans_time       = time();
                $eyb_student_answer->module_mark    = $total_mark;
                $eyb_student_answer->student_mark   = $obtain_mark;
                $eyb_student_answer->student_answer = json_encode($ans_array);
                $eyb_student_answer->exam_date      = date('Y-m');
                $eyb_student_answer->save();
            }
            $error['error']   = false; 
            $error['message'] = 'Your examination has been successfully completed.';
            $error['route'] = route('show_examination_answer',$eyb_student_answer->id);
            return response()->json($error);
        }else{
            $error['error']   = true; 
            $error['message'] = 'Moule id invalid!'; 
            return response()->json($error);
        }
    }
    public function show_examination_answer($module_id)
    {
        if(!is_numeric($module_id))
        {
            return redirect()->route('student_score');
        }

        $answer = eyb_student_answer::where('id',$module_id)->first();
        if($answer != false)
        {   
            $data['answer'] = $answer;
            
            $data['total_mark']     = $answer->module_mark;
            $data['obtain_mark']    = $answer->student_mark;  
            $std_ans = json_decode($answer->student_answer);
            $questions = array();
            foreach($std_ans as $key=>$ans)
            {
                $question = eyb_question::where('id',$ans->question_id)->first();
                $questions[$key] = $question;
                $questions[$key]['std_answer']   = json_decode($ans->student_ans);
                $questions[$key]['ans_is_right'] = $ans->ans_is_right;
            }
            $data['questions']      = $questions;
            $data['institute'] = DB::table('eyb_modules')
                                ->leftJoin('eyb_subjects','eyb_modules.subject','eyb_subjects.id')
                                ->leftJoin('eyb_level','eyb_modules.student_grade','eyb_level.id')
                                ->leftJoin('eyb_users','eyb_modules.user_id','eyb_users.id')
                                ->select('eyb_modules.module_name','eyb_modules.user_type','eyb_subjects.subject_name','eyb_level.level_name','eyb_users.name')
                                ->where('eyb_modules.id',$answer->module_id)
                                ->first();
            
            return view('front-end.exam.examination-answer',$data);
        }else{
            return redirect()->route('student_score');
        }
    }
    public function student_exam($module_id,$question_id,$q_order){
       
        if(!is_numeric($module_id))
        {
            return redirect()->route('module');
        }
        if(!is_numeric($question_id))
        {
            return redirect()->route('module');
        }
        if(!is_numeric($q_order))
        {
            return redirect()->route('module');
        }

        
        $data = array();
        $module     = $this->SingleModule($module_id);
        
        
        if(!empty($module))
        {
            if($module->module_type == 2)
            {
                $this->module_time_set($module);
            }
            $order = json_decode($module->question_order);
            $question_id_array = $order;
            $std_temp_answers = DB::table('eyb_std_temp_answers')
                                ->where('student_id',user_id())
                                ->where('module_id',$module_id)
                                ->first();
            $tem_ans = array();
            $total_mark = 0;
            if($std_temp_answers != false)
            {
                $tem_ans = json_decode($std_temp_answers->student_answer);
                $end_point = end($tem_ans);
                $temp_order_id = $end_point->question_order_id + 1;
                $question_id_array = $order;
                if (isset($question_id_array[$temp_order_id]))
                {
                    $temp_question_id = $question_id_array[$temp_order_id];
                }
                
                $temp_order_id = $temp_order_id + 1;
                $total_mark = $std_temp_answers->total_marks;
                     
                if($temp_question_id != $question_id)
                {
                    return Redirect()->route('student_exam',[$module_id,$temp_question_id,$temp_order_id]);
                }
                
            }
            $exist = in_array($question_id,$question_id_array);
            $next_question = $question_id;

            if (isset($question_id_array[$q_order]))
            {
                $next_question = $question_id_array[$q_order];
            }

            if ($exist == true)
            {

                $current_question = DB::table('eyb_questions')
                    ->where('id',$question_id)
                    ->first();
                $question_type = $current_question->question_type;

                $data['title'] = 'Exam';
                $data['module'] = $module;
                $data['module_id'] = $module_id;
                $data['next_question'] = $next_question;
                $data['question'] = $current_question;
                $data['question_type'] = $current_question->question_type;
                $data['q_order'] = $q_order+1;
                $data['tem_ans'] = $tem_ans;
                $data['total_mark'] = $total_mark;
                if ($question_type == 1) {
                    return view('front-end.exam.true-false', $data);
                }
                if ($question_type == 2)
                {
                    return view('front-end.exam.multiple-choice', $data);
                }
                if ($question_type == 5)
                {
                    return view('front-end.exam.fill-in-the-blank', $data);
                }
                if ($question_type == 7)
                {
                    return view('front-end.exam.multiple-image-choice', $data);
                }
            }
        }
    }
    public function tutor_exam($module_id,$question_id,$q_order)
    {
        $data = array();
        $module     = $this->SingleModule($module_id);
        if(!empty($module))
        {
            $order = json_decode($module->question_order);
            $question_id_array = $order;
            $exist = in_array($question_id,$question_id_array);
            $next_question = $question_id;
            if (isset($question_id_array[$q_order]))
            {
                $next_question = $question_id_array[$q_order];
            }
            echo '<pre>';
            print_r($next_question);
            die;
        }
        
    }
    public function tutor_exam_old($module_id,$question_id,$q_order)
    {
        $q_order = $q_order;
        $data = array();
        $user_id = $this->get_user();
        $module = DB::table('eyb_modules')
            ->where('id',$module_id)
            ->where('status',0)
            ->first();
        if(!empty($module))
        {
            $order = json_decode($module->question_order);
            $exist = in_array($question_id,$order);

            $next_question = $question_id;
            if (isset($order[$q_order]))
            {
                $next_question = $order[$q_order];
            }
            if ($exist == true)
            {
                $current_question = DB::table('eyb_questions')
                    ->where('id',$question_id)
                    ->first();
                $question_type = $current_question->question_type;
                $data['title'] = 'Exam';
                $data['module'] = $module;
                $data['module_id'] = $module_id;
                $data['next_question'] = $next_question;
                $data['question'] = $current_question;
                $data['question_type'] = $current_question->question_type;
                $data['q_order'] = $q_order+1;
                $data['module_user_type'] = 'tutor';

                if ($question_type == 1) {
                    return view('front-end.exam.true-false', $data);
                }
                if ($question_type == 2)
                {
                    return view('front-end.exam.multiple-choice', $data);
                }
            }
        }
    }
    public function ajax_student_exam($module_id,$question_id,$q_order)
    {
        $data = array();
        $module = DB::table('eyb_modules')
                    ->where('id',$module_id)
                    ->first();
        if(!empty($module))
        {
            $order              = json_decode($module->question_order);
            $question_id_array  = $order;
            $total_question     = count($question_id_array);
            $exist              = in_array($question_id,$question_id_array);
            $next_question      = $question_id;
            if (isset($question_id_array[$q_order])){
                $next_question = $question_id_array[$q_order];
            }
            if ($total_question == $q_order){
                $next_question = 0;
            }
            if ($exist == true)
            {
                $current_question = DB::table('eyb_questions')
                                        ->where('id',$question_id)
                                        ->first();
                $question_type = $current_question->question_type;
                $data['title']          = 'Exam';
                $data['module']         = $module;
                $data['module_id']      = $module_id;
                $data['next_question']  = $next_question;
                $data['question']       = $current_question;
                $data['q_order']        = $q_order+1;
                $data['question_type']  = $current_question->question_type;
                if ($question_type == 1) {
                    $view =  view('front-end.exam.ajax.true-false', $data);
                    $result = array();
                    $result['q_order']          = $q_order+1;
                    $result['module_id']        = $module_id;
                    $result['next_question']    = $next_question;
                    $result['question_id']      = $current_question->id;
                    $result['question_name']    = $current_question->question_name;
                    $result['view']             = $view->render();
                    echo json_encode($result);
                }
                if ($question_type == 2)
                {
                    $view =  view('front-end.exam.ajax.multiple-choice', $data);
                    $result = array();
                    $result['q_order']          = $q_order+1;
                    $result['module_id']        = $module_id;
                    $result['next_question']    = $next_question;
                    $result['question_id']      = $current_question->id;
                    $result['question_name']    = $current_question->question_name;
                    $result['view']             = $view->render();
                    echo json_encode($result);
                }
                if ($question_type == 5)
                {
                    $view =  view('front-end.exam.ajax.fill-in-the-blank', $data);
                    $result = array();
                    $result['q_order']          = $q_order+1;
                    $result['module_id']        = $module_id;
                    $result['next_question']    = $next_question;
                    $result['question_id']      = $current_question->id;
                    $result['question_name']    = $current_question->question_name;
                    $result['view']             = $view->render();
                    echo json_encode($result);
                }
                if ($question_type == 7)
                {
                    $view =  view('front-end.exam.ajax.multiple-image-choice', $data);
                    $result = array();
                    $result['q_order']          = $q_order+1;
                    $result['module_id']        = $module_id;
                    $result['next_question']    = $next_question;
                    $result['question_id']      = $current_question->id;
                    $result['question_name']    = $current_question->question_name;
                    $result['view']             = $view->render();
                    echo json_encode($result);
                }
            }
        }
    }
    public function valid_institute_practice_module($module_id)
    {
        $std_id     = $this->get_user();
        $std_info   = eyb_users::where('id',$std_id)->first();
        $inst_info  = InstituteStudent::where('user_id',$std_id)->first();
        
        $std_module = DB::table('eyb_student_answers')
                            ->select('module_id')
                            ->where('student_id',$std_id)
                            ->get();
        $json  = json_encode($std_module);
        $array = json_decode($json, true);
        $data = array();
        $modules_query = DB::table('eyb_modules')
                            ->leftJoin('eyb_module_types', 'eyb_modules.module_type', '=', 'eyb_module_types.id')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.id')
                            ->where('eyb_modules.user_id',$inst_info['institute_id'])
                            // ->where('eyb_modules.exam_time','<=',time())
                            // ->where('eyb_modules.exam_end','>=',time())
                            //->where('eyb_modules.exam_date','like','%'.date('Y-m-d').'%')
                            ->where('eyb_modules.student_grade',$inst_info['level']);
                            if ($inst_info->semester != 0) {
                              $modules_query->where('eyb_modules.semester',$inst_info->semester);
                            }
                            if ($inst_info->section != 0) {
                              $modules_query->where('eyb_modules.section',$inst_info->section);
                            }
            if (!empty($std_module)) {
                //$modules_query->whereNotIn('eyb_modules.id', array_column($array, 'module_id'));
            }
        $modules_query->orderBy('eyb_modules.id', 'asc');
        $result = $modules_query->get();
        $ids = array();
        if(count($result) > 0)
        {
            foreach ($result as $key => $value) {
                $ids[$key] = $value->id;
            }
        }

        if(in_array($module_id, $ids))
        {
            
        }else
        {
             $e_data['error']  = true;
             $e_data['exam_time']  = 1;
             $e_data['msg']    = 'You do not have permission for this test.';
             echo json_encode($e_data);
            die;
        }
    }
    public function valid_module($module_id)
    {

        $std_id     = $this->get_user();
        $std_info   = eyb_users::where('id',$std_id)->first();
        $inst_info  = InstituteStudent::where('user_id',$std_id)->first();
        
        $std_module = DB::table('eyb_student_answers')
                            ->select('module_id')
                            ->where('student_id',$std_id)
                            ->where('module_type',2)
                            ->get();
        $json  = json_encode($std_module);
        $array = json_decode($json, true);
        $data = array();
        $modules_query = DB::table('eyb_modules')
                            ->leftJoin('eyb_module_types', 'eyb_modules.module_type', '=', 'eyb_module_types.id')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.id')
                            ->where('eyb_modules.user_id',$inst_info['institute_id'])
                             // ->where('eyb_modules.exam_time','<=',time())
                             // ->where('eyb_modules.exam_end','>=',time())
                            ->where('eyb_modules.exam_date','like','%'.date('Y-m-d').'%')
                            ->where('eyb_modules.student_grade',$inst_info['level'])
                            ->where('eyb_modules.module_type',2);
                            if ($inst_info->semester != 0) {
                              $modules_query->where('eyb_modules.semester',$inst_info->semester);
                            }
                            if ($inst_info->section != 0) {
                              $modules_query->where('eyb_modules.section',$inst_info->section);
                            }
            if (!empty($std_module)) {
                $modules_query->whereNotIn('eyb_modules.id', array_column($array, 'module_id'));
            }
        $modules_query->orderBy('eyb_modules.id', 'asc');
        $result = $modules_query->get();
        $ids = array();
        if(count($result) > 0)
        {
            foreach ($result as $key => $value) {
                $ids[$key] = $value->id;
            }
        }

        if(in_array($module_id, $ids))
        {
            $module = eyb_module::where('id',$module_id)->first();

            if($module->exam_end < time())
            {
                $std_temp_answers = DB::table('eyb_std_temp_answers')
                                ->where('student_id',$std_id)
                                ->where('module_id',$module_id)
                                ->first();
                if (!empty($std_temp_answers)) {
                   $ans_array       = json_decode($std_temp_answers->student_answer);
                   $ans_count = count($ans_array);
                   $module_qs =   json_decode($module->question_order);
                   $ind_ans =  array();
                   $total_marks = 0;
                   $obtain_mark = 0;
                   foreach($module_qs as $key=>$module_q)
                   {
                        if(isset($ans_array[$key]))
                        {
                            $total_marks = $total_marks+$ans_array[$key]->student_question_marks;
                            $obtain_mark = $obtain_mark+$ans_array[$key]->student_marks;
                            
                        }else
                        {
                            $ques = eyb_question::where('id',$module_q)->first();
                            $total_marks = $total_marks+$ques->mark;
                            $obtain_mark = $obtain_mark+0;
                            $ans_array[$key]['question_order_id']       = $key;
                            $ans_array[$key]['module_type']             = $module->module_type;
                            $ans_array[$key]['module_id']               = $module_id;
                            $ans_array[$key]['question_id']             = $module_q;
                            $ans_array[$key]['student_ans']             = json_encode(0);
                            $ans_array[$key]['student_taken_time']      = '';
                            $ans_array[$key]['student_question_marks']  = $ques->mark;
                            $ans_array[$key]['student_marks']           = 0;
                            $ans_array[$key]['ans_is_right']            = 'wrong';
                            
                        }
                   }
                    $data['student_id']     = $std_id;
                    $data['level_id']       = $inst_info['level'];
                    $data['module_id']      = $module_id;
                    $data['module_type']    = $module->module_type;
                    $data['subject_id']     = $module->subject;
                    $data['user_id']        = $module->user_id;
                    $data['module_mark']    = $total_marks;
                    $data['student_mark']   = $obtain_mark;
                    $data['student_answer'] = json_encode($ans_array);
                    $data['created_at']     = date('Y-m-d H:i:s');
                    $data['updated_at']     = date('Y-m-d H:i:s');
                    DB::table('eyb_student_answers')->insert($data);
                    DB::table('eyb_std_temp_answers')->where('student_id', $std_id)->where('module_id', $module_id)->delete();
                    $e_data['error']      = true;
                    $e_data['exam_time']  = 1;
                    $e_data['msg']        = 'Exam time is over. You have successfully '.$ans_count.' question submitted' ;
                    echo json_encode($e_data);
                    die;
                }else
                {
                    $module_qs =   json_decode($module->question_order);
                    $ind_ans =  array();
                    $total_marks = 0;
                    foreach($module_qs as $key=>$module_q)
                    {
                        $ques = eyb_question::where('id',$module_q)->first();
                        $total_marks = $total_marks+$ques->mark;
                        $ind_ans[$key]['question_order_id'] = $key;
                        $ind_ans[$key]['module_type'] = $module->module_type;
                        $ind_ans[$key]['module_id'] = $module_id;
                        $ind_ans[$key]['question_id'] = $module_q;
                        $ind_ans[$key]['student_ans'] = json_encode(0);
                        $ind_ans[$key]['student_taken_time'] = '';
                        $ind_ans[$key]['student_question_marks'] = $ques->mark;
                        $ind_ans[$key]['student_marks'] = 0;
                        $ind_ans[$key]['ans_is_right'] = 'wrong';
                       
                    }

                    $data['student_id']     = $std_id;
                    $data['level_id']       = $inst_info['level'];
                    $data['module_id']      = $module_id;
                    $data['module_type']    = $module->module_type;
                    $data['subject_id']     = $module->subject;
                    $data['user_id']        = $module->user_id;
                    $data['module_mark']    = $total_marks;
                    $data['student_mark']   = 0;
                    $data['student_answer'] = json_encode($ind_ans);
                    $data['created_at']     = date('Y-m-d H:i:s');
                    $data['updated_at']     = date('Y-m-d H:i:s');
                    DB::table('eyb_student_answers')->insert($data);
                    $e_data['error']  = true;
                    $e_data['exam_time']  = 1;
                    $e_data['msg']    = 'Exam time is over.';
                    echo json_encode($e_data);
                    die;
                }
                die;
            } 
        }else
        {
             $e_data['error']  = true;
             $e_data['exam_time']  = 1;
             $e_data['msg']    = 'You do not have permission for this test.';
             echo json_encode($e_data);
        // echo '<pre>';
        // print_r($data);
        die;
        }
        
    }
    public function valid_exam_module($module_id)
    {

        $std_id     = $this->get_user();
        $std_info   = eyb_users::where('id',$std_id)->first();
        $std_module = DB::table('eyb_student_answers')
                            ->select('module_id')
                            ->where('student_id',$std_id)
                            ->where('module_type',2)
                            ->get();
        $json  = json_encode($std_module);
        $array = json_decode($json, true);
        $data = array();
        $modules_query = DB::table('eyb_modules')
                            ->leftJoin('eyb_module_types', 'eyb_modules.module_type', '=', 'eyb_module_types.id')
                            ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                            ->select('eyb_modules.id')
                            ->where('eyb_modules.user_id',1)
                             // ->where('eyb_modules.exam_time','<=',time())
                             // ->where('eyb_modules.exam_end','>=',time())
                            ->where('eyb_modules.exam_date','like','%'.date('Y-m-d').'%')
                            ->where('eyb_modules.module_type',2);
                            
            if (!empty($std_module)) {
                $modules_query->whereNotIn('eyb_modules.id', array_column($array, 'module_id'));
            }
        $modules_query->orderBy('eyb_modules.id', 'asc');
        $result = $modules_query->get();
        $ids = array();
        if(count($result) > 0)
        {
            foreach ($result as $key => $value) {
                $ids[$key] = $value->id;
            }
        }

        if(in_array($module_id, $ids))
        {
            $module = eyb_module::where('id',$module_id)->first();

            if($module->exam_end < time())
            {
                $std_temp_answers = DB::table('eyb_std_temp_answers')
                                ->where('student_id',$std_id)
                                ->where('module_id',$module_id)
                                ->first();
                if (!empty($std_temp_answers)) {
                   $ans_array       = json_decode($std_temp_answers->student_answer);
                   $ans_count = count($ans_array);
                   $module_qs =   json_decode($module->question_order);
                   $ind_ans =  array();
                   $total_marks = 0;
                   $obtain_mark = 0;
                   foreach($module_qs as $key=>$module_q)
                   {
                        if(isset($ans_array[$key]))
                        {
                            $total_marks = $total_marks+$ans_array[$key]->student_question_marks;
                            $obtain_mark = $obtain_mark+$ans_array[$key]->student_marks;
                            
                        }else
                        {
                            $ques = eyb_question::where('id',$module_q)->first();
                            $total_marks = $total_marks+$ques->mark;
                            $obtain_mark = $obtain_mark+0;
                            $ans_array[$key]['question_order_id']       = $key;
                            $ans_array[$key]['module_type']             = $module->module_type;
                            $ans_array[$key]['module_id']               = $module_id;
                            $ans_array[$key]['question_id']             = $module_q;
                            $ans_array[$key]['student_ans']             = json_encode(0);
                            $ans_array[$key]['student_taken_time']      = '';
                            $ans_array[$key]['student_question_marks']  = $ques->mark;
                            $ans_array[$key]['student_marks']           = 0;
                            $ans_array[$key]['ans_is_right']            = 'wrong';
                            
                        }
                   }
                    $data['student_id']     = $std_id;
                    $data['level_id']       = 0;
                    $data['module_id']      = $module_id;
                    $data['module_type']    = $module->module_type;
                    $data['subject_id']     = $module->subject;
                    $data['user_id']        = $module->user_id;
                    $data['module_mark']    = $total_marks;
                    $data['student_mark']   = $obtain_mark;
                    $data['student_answer'] = json_encode($ans_array);
                    $data['created_at']     = date('Y-m-d H:i:s');
                    $data['updated_at']     = date('Y-m-d H:i:s');
                    DB::table('eyb_student_answers')->insert($data);
                    DB::table('eyb_std_temp_answers')->where('student_id', $std_id)->where('module_id', $module_id)->delete();
                    $e_data['error']      = true;
                    $e_data['exam_time']  = 1;
                    $e_data['msg']        = 'Exam time is over. You have successfully '.$ans_count.' question submitted' ;
                    echo json_encode($e_data);
                    die;
                }else
                {
                    $module_qs =   json_decode($module->question_order);
                    $ind_ans =  array();
                    $total_marks = 0;
                    foreach($module_qs as $key=>$module_q)
                    {
                        $ques = eyb_question::where('id',$module_q)->first();
                        $total_marks = $total_marks+$ques->mark;
                        $ind_ans[$key]['question_order_id'] = $key;
                        $ind_ans[$key]['module_type'] = $module->module_type;
                        $ind_ans[$key]['module_id'] = $module_id;
                        $ind_ans[$key]['question_id'] = $module_q;
                        $ind_ans[$key]['student_ans'] = json_encode(0);
                        $ind_ans[$key]['student_taken_time'] = '';
                        $ind_ans[$key]['student_question_marks'] = $ques->mark;
                        $ind_ans[$key]['student_marks'] = 0;
                        $ind_ans[$key]['ans_is_right'] = 'wrong';
                       
                    }

                    $data['student_id']     = $std_id;
                    $data['level_id']       = 0;
                    $data['module_id']      = $module_id;
                    $data['module_type']    = $module->module_type;
                    $data['subject_id']     = $module->subject;
                    $data['user_id']        = $module->user_id;
                    $data['module_mark']    = $total_marks;
                    $data['student_mark']   = 0;
                    $data['student_answer'] = json_encode($ind_ans);
                    $data['created_at']     = date('Y-m-d H:i:s');
                    $data['updated_at']     = date('Y-m-d H:i:s');
                    DB::table('eyb_student_answers')->insert($data);
                    $e_data['error']  = true;
                    $e_data['exam_time']  = 1;
                    $e_data['msg']    = 'Exam time is over.';
                    echo json_encode($e_data);
                    die;
                }
                die;
            } 
        }else
        {
             $e_data['error']  = true;
             $e_data['exam_time']  = 1;
             $e_data['msg']    = 'You do not have permission for this test.';
             echo json_encode($e_data);
        // echo '<pre>';
        // print_r($data);
        die;
        }
        
    }
    public function check_is_right($question_id,$module_id,$q_order)
    {
        
        $result = 1;
        $module = DB::table('eyb_modules')
                    ->where('id',$module_id)
                    ->first();
            if (!empty($module))
            {
                if($module->user_type == 2 || $module->user_type == 4 || $module->user_type == 5)
                {
                    if($module->module_type == 2)
                    {
                        $this->valid_module($module_id);
                    }else{
                        
                        $this->valid_institute_practice_module($module_id);
                    }
                    
                }else{

                    if($module->module_type == 2)
                    {
                        $this->valid_exam_module($module_id);
                    }
                }

                $order = json_decode($module->question_order);
                $exist = in_array($question_id,$order);
                if ($exist != true)
                {
                    $result = 0;
                }else{
                    $total_question = count($order);
                    $total_question = $total_question+1;
                    if ($total_question < $q_order)
                    {
                        $result = 0;
                    }
                }
            }else{
                $result = 0;
            }
            return $result;
    }
    public function std_true_false(Request $request)
    {
        $data  =array();
        $question_id = $request->question_id;
        $module_id = $request->module_id;
        $q_order = $request->q_order;
        $next_question = $request->next_question;
        $std_answer = $request->answer;
        $check_is_right = $this->check_is_right($question_id,$module_id,$q_order);
        $data['error'] = false;
        $data['exam_time']  = 0;
        $data['msg'] = '';
        $ans_is_right = 'correct';
        if ($check_is_right == 1)
        {
            $question = DB::table('eyb_questions')
                ->where('id',$question_id)
                ->first();
            $answer = $question->answer;
            $mark = $question->mark;
            if ($std_answer != $answer)
            {
                $ans_is_right = 'wrong';
            }
            $this->judgment($mark, $question_id, $module_id, $q_order, $ans_is_right,$std_answer,$next_question);

        }else{
            $data['msg'] = '<ul><li>pass invalid data.refresh the page and try again</li></ul>';
            echo json_encode($data);
        }
    }
    public function QuestionInfo($question_id)
    {
        $question = DB::table('eyb_questions')
            ->where('id',$question_id)
            ->first();
        return $question;
    }
    public function std_answer_matching(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'question_id'   => 'required|numeric',
            'module_id'     => 'required|numeric',
            'q_order'       => 'required|numeric',
            'next_question' => 'required|numeric',
            'answer'        => 'required',

        ]);
        if ($validator->passes()) {

            $data  = array();
            $question_id    = $request->question_id;
            $module_id      = $request->module_id;
            $q_order        = $request->q_order;
            $next_question  = $request->next_question;
            $std_answer     = $request->answer;
            $check_is_right = $this->check_is_right($question_id,$module_id,$q_order);
            $data['error']  = false;
            $data['exam_time']  = 0;
            $data['msg']    = '';

            if ($check_is_right == 1)
            {
                $question           = $this->QuestionInfo($question_id);
                $question_type_f    = 'question_type_'.$question->question_type;
                $ans_is_right       = $this->$question_type_f($question,$std_answer);
                $mark               = $question->mark;
                $this->judgment($mark, $question_id, $module_id, $q_order, $ans_is_right,$std_answer,$next_question);
            }else{

                $data['msg'] = 'pass invalid data.refresh the page and try again';
                return response()->json(['error'=>$data['msg']]);
            }
        }
        return response()->json(['error'=>$validator->errors()->all()]);
        
        die;
    }
    public function question_type_1($question,$std_answer)
    {
        $answer = $question->answer;

        if ($answer != $std_answer)
        {
            return 'wrong';
        }else
        {
            return 'correct';
        }
    }
    public function question_type_2($question,$std_answer)
    {
        $question_ans = json_decode($question->answer);
        $answer = $question_ans->answer;

        if ($answer != $std_answer)
        {
            return 'wrong';
        }else
        {
            return 'correct';
        }
    }
    public function question_type_5($question,$std_answer)
    {
       
        $answer = str_replace(' ','',strtolower($question->answer));
        $std_answer = str_replace(' ','',strtolower($std_answer));
         
        if ($answer != $std_answer)
        {
            return 'wrong';
        }else
        {
            return 'correct';
        }
    }
    public function question_type_7($question,$std_answer)
    {
        $question_ans = json_decode($question->answer);
        $answer = $question_ans->answer;

        if ($answer != $std_answer)
        {
            return 'wrong';
        }else
        {
            return 'correct';
        }
    }

    public function judgment($mark, $question_id, $module_id, $q_order, $ans_is_right,$std_answer,$next_question)
    {
        $q_order = $q_order - 1;
        $result = array();
        $result['success']  = true;
        $result['result']   = '';
        $result['msg']      = '';
        $result['next_question'] = $next_question;
        $user_id = $this->get_user();
        $std_temp_answers = DB::table('eyb_std_temp_answers')
                                ->where('student_id',$user_id)
                                ->where('module_id',$module_id)
                                ->first();
        $ans_array = 0;
        if (!empty($std_temp_answers))
        {
            $obtained_marks  = $std_temp_answers->obtained_marks;
            $total_marks     = $std_temp_answers->total_marks;
            $ans_array       = json_decode($std_temp_answers->student_answer);
        }
        $tutorial_ans_info = DB::table('eyb_student_answers')
                                ->where('module_id',$module_id)
                                ->where('student_id',$user_id)
                                ->first();
        $question_info = $this->QuestionInfo($question_id);
        $module = DB::table('eyb_modules')
                    ->where('id',$module_id)
                    ->first();
        $negative_mark = $module->negative_mark;
        $result['ins_type'] = $module->user_type;
        $result['module_type'] = $module->module_type;
        $flag = 0;
        if ($tutorial_ans_info){
            //$flag = 2;
        }
        if (!is_array($ans_array)) {
            $ans_array = array();
            $obtained_marks = 0;
            $total_marks    = 0;
        } else {
            $question_idd = '';
            if (isset($ans_array[$q_order-1]->question_id)) {
                $question_idd = $ans_array[$q_order-1]->question_id;
            }
            if ($question_id == $question_idd) {
                $flag = 1;
            } else {
                $flag = 0;
            }
        }

        if ($ans_is_right == 'correct') {
            $result['msg']      = 'Your answer is correct.';
            $result['status']   = true;
        } else {
            $result['msg']      = 'Your answer is wrong.';
            $mark               = 0;
            $result['status']   = false;
        }

        if ($flag == 0)
        {
            if($mark == 0)
            {
                $obtained_marks = $obtained_marks - $negative_mark; 
            }
            $result['result'] = '<tr>
                              <th scope="row">'.$q_order.'</th>
                              <td>'.$ans_is_right.'</td>
                              <td>'.$question_info->mark.'</td>
                              <td>'.$mark.'</td>
                           </tr>';
            $result['obtain_mark'] = $obtained_marks + $mark;
            $result['total_mark']  = $total_marks + $question_info->mark;
        }elseif ($flag == 1)
        {
            $result['result']      = '';
            $result['obtain_mark'] = $obtained_marks;
            $result['total_mark']  = $total_marks;
        }
        
        if ($flag == 0) {

            $obtained_marks = $obtained_marks + $mark;

            $total_marks    = $total_marks + $question_info->mark;

            $ind_ans = array(
                'question_order_id'      => $q_order-1,
                'module_type'            => $module->module_type,
                'module_id'              => $module_id,
                'question_id'            => $question_id,
                'student_ans'            => json_encode($std_answer),
                'student_taken_time'     => '',
                'student_question_marks' => $question_info->mark,
                'student_marks'          => $mark,
                'ans_is_right'           => $ans_is_right
            );

            $ans_array[$q_order-1] = $ind_ans;
            $tem_ans = array();
            $tem_ans['student_id']      = $user_id;
            $tem_ans['module_id']       = $module_id;
            $tem_ans['student_answer']  = json_encode($ans_array);
            $tem_ans['obtained_marks']  = $obtained_marks;
            $tem_ans['total_marks']     = $total_marks;
            $tem_ans['updated_at']      = date('Y-m-d');
        //     echo '<pre>';
        // print_r($tem_ans);
        // die;
            if (!empty($std_temp_answers))
            {
                DB::table('eyb_std_temp_answers')
                    ->where('id', $std_temp_answers->id)
                    ->update($tem_ans);
            }else{
                $tem_ans['created_at'] = date('Y-m-d');
                DB::table('eyb_std_temp_answers')->insert($tem_ans);
            }
            if ($_POST['next_question'] == 0) {
//                $end_time = time();
//                session(['end_time' => $end_time]);
                $this->save_student_answer($module_id);
            }
        }
        // return response()->json($result);
        echo json_encode($result);
        die;
        
    }
    public function save_student_answer($module_id)
    {
        $user_id = $this->get_user();
        $module  = DB::table('eyb_modules')
                            ->where('id',$module_id)
                            ->first();
        $user = DB::table('eyb_users')
                            ->where('id',$user_id)
                            ->first();

        $std_temp_answers = DB::table('eyb_std_temp_answers')
                                ->where('student_id',$user_id)
                                ->where('module_id',$module_id)
                                ->first();
        // DB::table('eyb_student_answers')->where('student_id', $user_id)->where('module_id', $module_id)->delete();
        $eyb_student_answer = eyb_student_answer::where('student_id',$user_id)->where('module_id', $module_id)->where('module_type',$module->module_type)->first();
        $obtained_marks = 0;
        $total_marks    = 0;
        $ans_array      = 0;
        if (!empty($std_temp_answers))
        {
            $obtained_marks = $std_temp_answers->obtained_marks;
            $total_marks    = $std_temp_answers->total_marks;
            $ans_array      = json_decode($std_temp_answers->student_answer);
        }
        if($eyb_student_answer != false)
        {
            $eyb_student_answer->module_mark    = $total_marks;
            $eyb_student_answer->student_mark   = $obtained_marks;
            $eyb_student_answer->student_answer = json_encode($ans_array);
            $eyb_student_answer->update();
        }else{
            $eyb_student_answer = new eyb_student_answer();
            $eyb_student_answer->student_id     = $user_id;
            $eyb_student_answer->level_id       = $user->student_grade;
            $eyb_student_answer->module_id      = $module_id;
            $eyb_student_answer->subject_id     = $module->subject;
            $eyb_student_answer->module_type    = $module->module_type;
            $eyb_student_answer->user_id        = $module->user_id;
            $eyb_student_answer->module_mark    = $total_marks;
            $eyb_student_answer->student_mark   = $obtained_marks;
            $eyb_student_answer->student_answer = json_encode($ans_array);
            $eyb_student_answer->exam_date      = date('Y-m');
            $eyb_student_answer->save();
        }   
        // $data['student_id']     = $user_id;
        // $data['level_id']       = $user->student_grade;
        // $data['module_id']      = $module_id;
        // $data['subject_id']     = $module->subject;
        // $data['module_type']    = $module->module_type;
        // $data['user_id']        = $module->user_id;
        // $data['module_mark']    = $total_marks;
        // $data['student_mark']   = $obtained_marks;
        // $data['student_answer'] = json_encode($ans_array);
        // $data['student_answer'] = json_encode($ans_array);
        // $data['exam_date']      = date('Y-m');
        // $data['created_at']     = date('Y-m-d H:i:s');
        // $data['updated_at']     = date('Y-m-d H:i:s');

        // DB::table('eyb_student_answers')->insert($data);
        // $update_module['status'] = 1;
        // DB::table('eyb_modules')
        //     ->where('id', $module_id)
        //     ->update($update_module);
        DB::table('eyb_std_temp_answers')->where('student_id', $user_id)->where('module_id', $module_id)->delete();
    }
    public function show_result($module_id)
    {
        $user_id = $this->get_user();
        $module = DB::table('eyb_student_answers')
            ->where('module_id',$module_id)
            ->where('student_id',$user_id)
            ->first();
        $user = DB::table('eyb_users')
            ->where('id',$user_id)
            ->first();
        $md = DB::table('eyb_modules')
            ->where('id',$module_id)
            ->first();
        $data = array();
        $data['user_name'] = $user->name;
        $data['module_name'] = $md->module_name;
        $data['module_mark'] = $module->module_mark;
        $data['student_mark'] = $module->student_mark;
        $data['student_answers'] = json_decode($module->student_answer);
        $view =  view('front-end.exam.show-result', $data);
        $result['view'] = $view->render();
        echo json_encode($result);

    }

}
