<?php

namespace App\Http\Controllers;
use App\eyb_subject;
use App\eyb_users;
use App\Section;
use App\Semester;
use Illuminate\Http\Request;
use DB;
use App\eyb_module;
use App\InstituteStudent;
use Validator;
class ExamReport extends Controller
{
    public function ExamReport()
    {
    	$admin_id = admin_id();
        if(session('super_status'))
        {
            $admin_id = 1;
        }
        $data = array();
        $data['levels']         = $this->level();
        $data['module_types']   = $this->ModuleType();
        $data['question_types'] = $this->QuestionType();
    	return view('admin.exam-report.exam-report',$data);
    }
    public function level()
    {
        $admin_id = admin_id();
        if(session('super_status'))
        {
            $admin_id = 1;
        }
        $levels = DB::table('eyb_level')->where('user_id',$admin_id)->get();
        return $levels;
    }
    public function Subject()
    {
        $admin_id = admin_id();
        if(session('super_status'))
        {
            $admin_id = 1;
        }
        $subjects = DB::table('eyb_subjects')->where('user_id',$admin_id)->get();
        return $subjects;
    }public function ModuleType()
    {
        $module_types = DB::table('eyb_module_types')->get();
        return $module_types;
    }
    public function QuestionType()
    {
        $question_types = DB::table('eyb_question_types')->where('status',1)->get();
        return $question_types;
    }
    public function exam_report(Request $request)
    {
    	if (admin_type() == 2)
        {
            $required = array();

            // $validator = Validator::make($request->all(), [

            //     'module_type'         => 'numeric',
            //     'student_grade'       => 'required|numeric',
            //     'subjects'            => 'required|numeric',
            //     'section'             => 'numeric',
            //     'semester'            => 'numeric',
            //     'exam_date'           => 'date',

            // ]);
            $validatedData = $request->validate([
                'module_type'         => 'numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'section'             => 'numeric',
                'semester'            => 'numeric',
                // 'exam_date'           => 'date',
            ]);
        }elseif(admin_type() == 5)
        {
            // $validator = Validator::make($request->all(), [

            //     'module_type'         => 'numeric',
            //     'student_grade'       => 'required|numeric',
            //     'subjects'            => 'required|numeric',
            //     'exam_date'           => 'required|date',

            // ]);
            $validatedData = $request->validate([
                'module_type'         => 'numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                // 'exam_date'           => 'date',
            ]);
        }elseif(admin_type() == 4)
        {
            
            $validatedData = $request->validate([
                'module_type'         => 'numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'section'             => 'numeric',
                // 'exam_date'           => 'date',
            ]);
        }elseif(admin_type() == 1)
        {
            $validatedData = $request->validate([
                'module_type'         => 'numeric',
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
            ]);
        }

        // if ($validator->passes()) {

        	$condition = array();
            if ($request->module_type > 0 )
            {
                // $condition['eyb_modules.module_type'] = $request->module_type;
                $condition['eyb_student_answers.module_type'] = $request->module_type;
            }
            if ($request->student_grade > 0 )
            {
                $condition['eyb_modules.student_grade'] = $request->student_grade;
            }
            if ($request->subjects > 0 )
            {
                $condition['eyb_modules.subject'] = $request->subjects;
            }
            if ($request->semester > 0 )
            {
                $condition['eyb_modules.semester'] = $request->semester;
            }
            if ($request->section > 0 )
            {
                $condition['eyb_modules.section'] = $request->section;

            }
            
          //   $modules = DB::table('eyb_modules')->get();
          //   foreach($modules as $md)
          //   {
          //   	$time 	= strtotime($md->created_at);
          //   	$date 	= date('Y-m-d',strtotime($md->created_at));
          //   	//$date 	= date('Y-m-d H:i:s',strtotime($md->created_at));
          //   	$id 	= $md->id;
          //   	$mod = eyb_module::where('id',$id)->first();
          //   	$mod->exam_date = $date;
          //   	$mod->exam_time = $time;
          //   	$mod->update();
          //   	
          //   }
            
            $user_id    = admin_id();
            if(session('super_status'))
            {
                $user_id = 1;
            }
            $user_type  = admin_type();
            $condition['eyb_modules.user_id'] = $user_id;
            if($request->exam_date != '')
            {
                $modules = DB::table('eyb_modules')
                        ->leftJoin('eyb_student_answers', 'eyb_modules.id', '=', 'eyb_student_answers.module_id')
                        ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                        ->leftJoin('eyb_module_types', 'eyb_modules.module_type', '=', 'eyb_module_types.id')
                        ->leftJoin('sections', 'eyb_modules.section', '=', 'sections.id')
                        ->leftJoin('semesters', 'eyb_modules.semester', '=', 'semesters.id')
                        ->leftJoin('eyb_level', 'eyb_modules.student_grade', '=', 'eyb_level.id')
                        ->leftJoin('institute_students', 'eyb_student_answers.student_id', '=', 'institute_students.user_id')
                        ->select('eyb_modules.id','eyb_modules.module_name','eyb_subjects.subject_name','eyb_module_types.module_type','sections.name','semesters.semester_name','eyb_level.level_name','institute_students.name as std_name','institute_students.roll_no','eyb_student_answers.module_mark as qus_mark','eyb_student_answers.student_mark as student_mark')
                        ->where($condition)
                        ->where('exam_date','like','%'.$request->exam_date.'%')
                        ->orderBy('id','DESC')
                        ->get();
            }else{
                $modules = DB::table('eyb_modules')
                        ->leftJoin('eyb_student_answers', 'eyb_modules.id', '=', 'eyb_student_answers.module_id')
                        ->leftJoin('eyb_subjects', 'eyb_modules.subject', '=', 'eyb_subjects.id')
                        ->leftJoin('eyb_module_types', 'eyb_modules.module_type', '=', 'eyb_module_types.id')
                        ->leftJoin('sections', 'eyb_modules.section', '=', 'sections.id')
                        ->leftJoin('semesters', 'eyb_modules.semester', '=', 'semesters.id')
                        ->leftJoin('eyb_level', 'eyb_modules.student_grade', '=', 'eyb_level.id')
                        ->leftJoin('institute_students', 'eyb_student_answers.student_id', '=', 'institute_students.user_id')
                        ->select('eyb_modules.id','eyb_modules.module_name','eyb_subjects.subject_name','eyb_module_types.module_type','sections.name','semesters.semester_name','eyb_level.level_name','institute_students.name as std_name','institute_students.roll_no','eyb_student_answers.module_mark as qus_mark','eyb_student_answers.student_mark as student_mark')
                        ->where($condition)
                        ->orderBy('id','DESC')
                        ->get();
            }
            

                        // echo '<pre>';
                        // print_r($modules);
                        // die;
            return view('admin.exam-report.report',['modules'=>$modules]);

        // }else
        // {

        // 	 return response()->json(['error'=>$validator->errors()->all()]);
        // }
    }

    public function module_report()
    {
        $user_id    = admin_id();
        if(session('super_status'))
        {
            $user_id = 1;
        }
        $data['levels']         = $this->level();
        
        return view('admin.exam-report.module-report',$data);
    }

    public function get_modules(Request $request)
    {
        if (admin_type() == 2)
        {
            $validator = Validator::make($request->all(), [

                
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'section'             => 'required|numeric',
                'semester'            => 'required|numeric',

            ]);
        }elseif(admin_type() == 5)
        {
            $validator = Validator::make($request->all(), [

                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',

            ]);
        }elseif(admin_type() == 4)
        {
            $validator = Validator::make($request->all(), [

                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'section'             => 'required|numeric',
            ]);
        }elseif(admin_type() == 1)
        {
            $validator = Validator::make($request->all(), [

                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
            ]);
        }
        if ($validator->passes()) {

            $condition = array();
            
            if ($request->student_grade > 0 )
            {
                $condition['student_grade'] = $request->student_grade;
            }
            if ($request->subjects > 0 )
            {
                $condition['subject'] = $request->subjects;
            }
            if ($request->semester > 0 )
            {
                $condition['semester'] = $request->semester;
            }
            if ($request->section > 0 )
            {
                $condition['section'] = $request->section;

            }
            $user_id    = admin_id();
            if(session('super_status'))
            {
                $user_id = 1;
            }
            $condition['eyb_modules.user_id'] = $user_id;

            $modules = eyb_module::where($condition)->orderBy('id','DESC')->get();
            $count = count($modules);
            $html = '<option>Select Module</option>';
            if ($count > 0)
            {
                foreach($modules as $module)
                {
                   $html .= '<option value="'.$module->id.'">'.$module->module_name.'</option>';
                }
            }
            return response()->json(['success'=>$html]);
        }else{
            return response()->json(['error'=>$validator->errors()->all()]);
        }
        
    }
    public function module_report_generate(Request $request)
    {
       
        if (admin_type() == 2)
        {
            $validator = Validator::make($request->all(), [

                
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'module'              => 'required|numeric',

            ]);
        }elseif(admin_type() == 5)
        {
            $validator = Validator::make($request->all(), [

                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'module'              => 'required|numeric',

            ]);
        }elseif(admin_type() == 4)
        {
            $validator = Validator::make($request->all(), [

                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'module'              => 'required|numeric',
            ]);
        }elseif(admin_type() == 1)
        {
            $validator = Validator::make($request->all(), [

                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'module'              => 'required|numeric',
            ]);
        }
        if ($validator->passes()) {

            $condition = array();
            
            if ($request->module > 0 )
            {
                $condition['eyb_student_answers.module_id'] = $request->module;
            }
            $user_id    = admin_id();
            if(session('super_status'))
            {
                $user_id = 1;
            }
            $condition['eyb_student_answers.user_id'] = $user_id;
             //DB::enableQueryLog();
            $modules_query = DB::table('eyb_student_answers')
                        ->leftJoin('eyb_modules', 'eyb_student_answers.module_id', '=', 'eyb_modules.id')
                        ->leftJoin('eyb_users', 'eyb_student_answers.student_id', '=', 'eyb_users.id')
                        ->leftJoin('districts', 'eyb_users.district_id', '=', 'districts.id')
                        ->select('eyb_modules.module_name','eyb_student_answers.module_mark','eyb_student_answers.student_mark','eyb_users.name','districts.bn_name','eyb_student_answers.student_answer')
                        ->where($condition)
                        ->orderBy('eyb_student_answers.student_mark','DESC');
            if($request->top == 'all')
            {
                $result = $modules_query->get();
            }else{
                $result = $modules_query->take($request->top)->get();
            }
            //$query = DB::getQueryLog();
            
              $view =  view('admin.exam-report.exam-list',['modules'=>$result]);
              $result['view'] = $view->render();
            return response()->json(['success'=>$result]);
        }else{
            return response()->json(['error'=>$validator->errors()->all()]);
        }
    }

    public function module_generate_pdf(Request $request)
    {
        if (admin_type() == 2)
        {
            $validator = Validator::make($request->all(), [

                
                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'module'              => 'required|numeric',

            ]);
        }elseif(admin_type() == 5)
        {
            $validator = Validator::make($request->all(), [

                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'module'              => 'required|numeric',

            ]);
        }elseif(admin_type() == 4)
        {
            $validator = Validator::make($request->all(), [

                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'module'              => 'required|numeric',
            ]);
        }elseif(admin_type() == 1)
        {
            $validator = Validator::make($request->all(), [

                'student_grade'       => 'required|numeric',
                'subjects'            => 'required|numeric',
                'module'              => 'required|numeric',
            ]);
        }
        if ($validator->passes()) {

            $condition = array();
            
            if ($request->module > 0 )
            {
                $condition['eyb_student_answers.module_id'] = $request->module;
            }
            $user_id    = admin_id();
            if(session('super_status'))
            {
                $user_id = 1;
            }
            $condition['eyb_student_answers.user_id'] = $user_id;

            $modules_query = DB::table('eyb_student_answers')
                        ->leftJoin('eyb_modules', 'eyb_student_answers.module_id', '=', 'eyb_modules.id')
                        ->leftJoin('eyb_users', 'eyb_student_answers.student_id', '=', 'eyb_users.id')
                        ->leftJoin('districts', 'eyb_users.district_id', '=', 'districts.id')
                        ->select('eyb_modules.module_name','eyb_student_answers.module_mark','eyb_student_answers.student_mark','eyb_users.name','districts.bn_name','eyb_student_answers.student_answer')
                        ->where($condition)
                        ->orderBy('eyb_student_answers.student_mark','DESC');
            if($request->top == 'all')
            {
                $data['modules'] = $modules_query->get();
            }else{
                $data['modules'] = $modules_query->take($request->top)->get();
            }
            // if($user_id == 1)
            // {
            //     $data['institute_name'] = 'রংধনু পাঠশালা';
            // }else{
            //     $Institute = eyb_users::where('id',haveInstituteStudent()->institute_id)->first();
            //     $data['institute_name'] = ucwords(strtolower($Institute->name));
            // }
            $data['module'] = eyb_module::where('id',$request->module)->first();
            $order = json_decode($data['module']->question_order);
            $data['subject'] = eyb_subject::where('id',$data['module']->subject)->first();
            $data['institute'] = DB::table('eyb_modules')
                                ->leftJoin('eyb_subjects','eyb_modules.subject','eyb_subjects.id')
                                ->leftJoin('eyb_level','eyb_modules.student_grade','eyb_level.id')
                                ->leftJoin('eyb_users','eyb_modules.user_id','eyb_users.id')
                                ->select('eyb_modules.module_name','eyb_modules.user_type','eyb_subjects.subject_name','eyb_level.level_name','eyb_users.name')
                                ->where('eyb_modules.id',$request->module)
                                ->first();
            $data['total_mark'] = Db::table('eyb_questions')->whereIn('id', $order)->sum('mark');
           // echo '<pre>';
           //  print_r($data);
           //  die;
            $view =  view('admin.exam-report.pdf',$data);
            $result['view'] = $view->render();
            return response()->json(['success'=>$result]);
        }else{
            return response()->json(['error'=>$validator->errors()->all()]);
        }
    }
}
