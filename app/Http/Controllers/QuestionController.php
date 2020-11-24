<?php

namespace App\Http\Controllers;

use App\eyb_module;
use App\Section;
use App\Semester;
use Illuminate\Http\Request;
use App\eyb_level;
use App\eyb_question;
use App\StudentBatch;
use DB,Validator;
use Image;
class QuestionController extends Controller
{
    public function ManageQuestion()
    {
        $admin_id = admin_id();
        if(session('super_status'))
        {
            $admin_id = 1;
        }
        $data = array();
        $data['question_types'] = DB::table('eyb_question_types')->where('status',1)->get();
        $data['levels'] = DB::table('eyb_level')->where('user_id',$admin_id)->get();
        return view('admin.question.manage-question',$data);
    }

    public function manage_question_type($id)
    {
        if(!is_numeric($id))
        {
            return redirect()->back();
        }
        $admin_id   = admin_id();
        if(session('super_status'))
        {
            $admin_id = 1;
        }
        $levels                 = DB::table('eyb_level')->where('user_id',$admin_id)->get();
        $data                   = array();
        $data['levels']         = $levels;
        $data['question_types'] = DB::table('eyb_question_types')->where('status',1)->get();
        $data['type']           = $id;
        
        return view('admin.question.manage-question-type',$data);
    }
    public function print($data)
    {
        echo '<pre>';
        print_r($data);
        die;
    }
    public function get_user()
    {
        // $get_session = session('user_id');
        // $user = DB::table('eyb_users')
        //     ->where('log',$get_session)
        //     ->first();
        // $user_id = $user->id;
        return session('user_id');
    }

    public function CreateQuestion($qus_type)
    {
        $admin_id   = admin_id();
        if(session('super_status'))
        {
            $admin_id = 1;
        }
        $levels     = DB::table('eyb_level')->where('user_id',$admin_id)->get();
        $data       = array();
        $data['levels'] = $levels;
        if ($qus_type == 1)
        {
            return view('admin.tutors.question-box.true-false',$data);
        }
        if ($qus_type == 2)
        {
            return view('admin.tutors.question-box.multiple-choice',$data);
        }
        if ($qus_type == 3)
        {
            return view('admin.tutors.question-box.multiple-response',$data);
        }
        if ($qus_type == 4)
        {
            return view('admin.tutors.question-box.matching',$data);
        }
        if ($qus_type == 5)
        {
            return view('admin.tutors.question-box.fill-in-the-blanks',$data);
        }
        if ($qus_type == 6)
        {
            return view('admin.tutors.question-box.tutorial',$data);
        }
        if ($qus_type == 7)
        {
            return view('admin.tutors.question-box.image-response',$data);
        }
        //return view('admin.manage-question',$data);
    }
    public function get_subject($id)
    {
        $admin_id = admin_id();
        if(session('super_status'))
        {
            $admin_id = 1;
        }
        $subjects = DB::table('eyb_subjects')->where('level_id',$id)->where('status',1)->where('user_id',$admin_id)->get();
        $semesters = Semester::where('level_id',$id)->where('user_id',$admin_id)->get();
        $sections = Section::where('level_id',$id)->where('user_id',$admin_id)->get();
        $batches = StudentBatch::where('level_id',$id)->where('user_id',$admin_id)->where('start_date','<=',date('Y-m-d'))->where('end_date','>=',date('Y-m-d'))->get();
        $html = '<option value="">Select Subject</option>';
        if (!empty($subjects))
        {

            foreach ($subjects as $subject)
            {
                $html .= '<option value="'.$subject->id.'">'.$subject->subject_name.'</option>';
            }
        }
        $data['subject'] = $html;
       
        if (admin_type() == 2 || admin_type() == 1) {
            $semester_html = '<option value="">Select Semester</option>';
            if (!empty($semesters)) {

                foreach ($semesters as $semester) {
                    $semester_html .= '<option value="' . $semester->id . '">' . $semester->semester_name . '</option>';
                }
            }
            $data['semester'] = $semester_html;
        }

        if ( admin_type() != 5) {
            $section_html = '<option value="">Select Section</option>';
            if (!empty($sections)) {

                foreach ($sections as $section) {
                    $section_html .= '<option value="' . $section->id . '">' . $section->name . '</option>';
                }
            }
            $data['section'] = $section_html;
        }
        if ( admin_type() == 5 || admin_type() == 1) {
            $batch_html = '<option value="">Select Batch</option>';
            if (!empty($batches)) {

                foreach ($batches as $batch) {
                    $batch_html .= '<option value="' . $batch->id . '">' . $batch->batch_name . '</option>';
                }
            }
            $data['batch'] = $batch_html;
        }
        
        echo json_encode($data);
    }
    public function ManageModule()
    {
        $tutor_id = admin_id();
        $modules = eyb_module::where('user_id',$tutor_id);
        return view('admin.tutors.module.all-module',['modules'=>$modules]);
    }
    public function save_question(Request $request)
    {


        $rules = [
            'student_grade' => 'required|numeric|max:100',
            'subjects'      => 'required|numeric|max:100',
            'question_mark' => 'required|numeric|max:10',
            'question_name' => 'required|max:250',
        ];
        if ($request->explanation != '')
        {
            $rules['explanation'] = 'max:250';
        }
        if ($request->type != 5)
        {
            $rules['answer'] = 'required';
        }else{

            $rules['answer'] = 'required';
        }
        $customMessages = [
            'student_grade.required'    => 'Please Provide Student Grade',
            'subjects.required'         => 'Please Provide Student Subject',
            'question_mark.required'    => 'Please Provide Question Mark',
            'question_name.required'    => 'Please Provide Question',
            'answer.required'           => 'Please Provide Question Answer',
        ];
        $validator = $this->validate($request, $rules, $customMessages);
        
        $data = array();
        $data['question_type'] = $request->input('type');
        $data['subject'] = $request->input('subjects');
        if(session('super_status'))
        {
            $data['user_id'] = 1;
        }else{
            $data['user_id'] = admin_id();
        }
        
        $data['student_grade'] = $request->input('student_grade');
        $data['question_name'] = $request->input('question_name');
        $data['question_description'] = $request->input('explanation');
        $question_type_f = 'question_type_'.$request->input('type');
        $data['answer'] = $this->$question_type_f($request->all());
        $data['mark'] = $request->input('question_mark');
        $data['created_at'] = date("Y-m-d");
        $data['updated_at'] = date("Y-m-d");
        DB::table('eyb_questions')->insert($data);

        return redirect()->back()->with('success_message','Question Inserted Successfully!');

    }
    public function question_type_1($request)
    {

        return $request['answer'];
    }
    public function question_type_2($request)
    {
        $data = array();
        $answer_choice = $request['answer_choice'];
        $data['answer'] = $request['answer'];
        $image_quantity = $request['image_quantity'];
        $data['image_quantity'] = $image_quantity;
        $answer_choices = array();
        for($i=0;$i<$image_quantity;$i++)
        {
            $answer_choices[$i]['answer_choice'] = $answer_choice[$i];
        }
        $data['answer_choice'] = $answer_choices;
        return json_encode($data);
    }
    public function question_type_5($request)
    {
        return $request['answer'];
        
    }
    public function question_type_7($request)
    {
        $data = array();
        $data['image_quantity'] = $request['image_quantity'];
        $data['answer'] = $request['answer'];
        $files = $request['Image'];
        $answer_choices = array();
        foreach($files as $key=>$file)
        {
            $image_name = time().'-'.rand(10000,99999).'.'.$file->getClientOriginalExtension();
            $file->move("public/assets/image-response/origin/", $image_name);
            $image_path = "assets/image-response/origin/" . $image_name;

            $destinationPath = 'public/assets/image-response/answer/';
             Image::make('public/assets/image-response/origin/'.$image_name)->widen(960)->heighten(960)->orientate()->crop(960,960)->save($destinationPath.'/'.$image_name);
             $answer_choices[$key]['origin'] = $image_path; 
             $answer_choices[$key]['answer'] = $destinationPath.$image_name;  
        }
        $data['answer_choices'] = $answer_choices;
        return json_encode($data);
        
    }
    public function get_total_question($id)
    {
        if ($id != '')
        {
            $count = DB::table('eyb_questions')
                ->select(DB::raw('count(id) as count'))
                ->where('subject',$id)
                ->get();
            $data['count']  = $count[0]->count;
            echo json_encode($data);
        }

    }
    public function question_search(Request $request)
    {
        $validator = Validator::make($request->all(), [

                'student_grade'    => 'required|numeric',
                'subjects'         => 'required|numeric',
            ]);

        if ($validator->passes()){
            $user_id = admin_id();
            if(session('super_status'))
            {
                $user_id = 1;
            }
            $level_id   = $request->student_grade;
            $subject_id = $request->subjects;
            $type       = $request->type;
            $questions = array();
            if ($type != '')
            {
                $questions = DB::table('eyb_questions')
                    ->leftJoin('eyb_question_types', 'eyb_questions.question_type', '=', 'eyb_question_types.id')
                    ->select('eyb_questions.id','eyb_questions.question_name','eyb_question_types.type')
                    ->where('student_grade',$level_id)
                    ->where('subject',$subject_id)
                    ->where('question_type',$type)
                    ->where('user_id',$user_id)
                    ->paginate(30);
                $total_question = DB::table('eyb_questions')
                                ->where('student_grade',$level_id)
                                ->where('subject',$subject_id)
                                ->where('question_type',$type)
                                ->where('user_id',$user_id)
                                ->count();
            }else
            {
                $questions = DB::table('eyb_questions')
                    ->leftJoin('eyb_question_types', 'eyb_questions.question_type', '=', 'eyb_question_types.id')
                    ->select('eyb_questions.id','eyb_questions.question_name','eyb_question_types.type')
                    ->where('student_grade',$level_id)
                    ->where('subject',$subject_id)
                    ->where('user_id',$user_id)
                    ->paginate(30);
                $total_question = DB::table('eyb_questions')
                                ->where('student_grade',$level_id)
                                ->where('subject',$subject_id)
                                ->where('user_id',$user_id)
                                ->count();
            }
            $start = 1;
            if($questions->currentPage() > 1)
            {
                $start = (($questions->currentPage() - 1) * 30) + 1;
            }
            // echo '<pre>';
            // print_r($questions->currentPage());
            // die;
            $view =  view('admin.question.question-content',['questions'=>$questions,'start'=>$start,'total_question'=>$total_question]);
            echo  $view->render();
            // echo json_encode($result);
            die;
            // return response()->json(['success'=>$html]);
        }else{

            return response()->json(['error'=>$validator->errors()->all()]);
        }

        // $results->count()
        // $results->currentPage()
        // $results->firstItem()
        // $results->hasMorePages()
        // $results->lastItem()
        // $results->lastPage() (Not available when using simplePaginate)
        // $results->nextPageUrl()
        // $results->perPage()
        // $results->previousPageUrl()
        // $results->total() (Not available when using simplePaginate)
        // $results->url($page)
    }
    public function QuestionInfo($question_id,$check = false)
    {
        $user_id = admin_id();
        if(session('super_status'))
        {
            $user_id = 1;
        }
        if ($check == true)
        {
            $question = DB::table('eyb_questions')
                ->where('id',$question_id)
                ->where('user_id',$user_id)
                ->first();
        }else{
            $question = DB::table('eyb_questions')
                ->where('id',$question_id)
                ->first();
        }
        return $question;
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
    }
    public function edit_question($id)
    {
        $question = $this->QuestionInfo($id,true);
        $admin_id = admin_id();
        if(session('super_status'))
        {
            $admin_id = 1;
        }
        if (!empty($question))
        {
            $data['question'] = $question;
            $data['levels'] = $this->level();
            $data['subjects'] = DB::table('eyb_subjects')->where('user_id',$admin_id)->where('level_id',$data['question']->student_grade)->where('status',1)->get();
            $file_name[1] = 'true-false';
            $file_name[2] = 'multiple-choice';
            $file_name[5] = 'fill-in-the-blanks';
            $file_name[7] = 'image-response';
            
            return view('admin.tutors.edit-question-box.'.$file_name[$question->question_type],$data);
        }else {
            echo 'try to valid question';
        }
    }
    public function update_question_type_7($request,$question_id)
    {
        $question = eyb_question::where('id',$question_id)->first();
        $ex_ans = json_decode($question->answer);
        $image_quantity = $request['image_quantity'];
        $Image = array();
        if (isset($request['Image'])) {
           $Image = $request['Image'];
        }
        
        $ex_choice = $ex_ans->answer_choices;
        
        $answer_choices = array();
        if(count($Image) > 0)
        {
            for($i=0;$i<$image_quantity;$i++)
            {
                if(isset($Image[$i]))
                {
                    if(isset($ex_choice[$i]))
                    {
                        $Opath = base_path().'/'.$ex_choice[$i]->origin;
                        $Apath = base_path().'/'.$ex_choice[$i]->answer;
                        if($ex_choice[$i]->origin != '')
                        {
                            if (file_exists($Opath)) {
                                unlink($Opath);
                            }
                        }
                        if($ex_choice[$i]->answer != '')
                        {
                            if (file_exists($Apath)) {
                                unlink($Apath);
                            }
                        }  
                    }
                    $file = $Image[$i];
                    $image_name = time().'-'.rand(10000,99999).'.'.$file->getClientOriginalExtension();
                    $file->move("assets/image-response/origin/", $image_name);
                    $image_path = "assets/image-response/origin/" . $image_name;

                    $destinationPath = 'assets/image-response/answer/';
                     Image::make('assets/image-response/origin/'.$image_name)->widen(960)->heighten(960)->orientate()->crop(960,960)->save($destinationPath.'/'.$image_name);
                     $answer_choices[$i]['origin'] = $image_path; 
                     $answer_choices[$i]['answer'] = $destinationPath.$image_name;
                    
                }else{
                    if(isset($ex_choice[$i]))
                    {
                        $answer_choices[$i]['origin'] = $ex_choice[$i]->origin; 
                        $answer_choices[$i]['answer'] = $ex_choice[$i]->answer;
                    } 
                }
            }
        }else{
            $answer_choices = $ex_choice;
        }
        $data = array();
        $data['image_quantity'] = $request['image_quantity'];
        $data['answer'] = $request['answer'];
        $data['answer_choices'] = $answer_choices;
        return json_encode($data);
        
    }
    public function update_question(Request $request,$id)
    {

        
        $rules = [
            'student_grade' => 'required|numeric|max:100',
            'subject' => 'required|numeric|max:100',
            'question_mark' => 'required|numeric|max:10',
            'question_name' => 'required|max:250',
            
        ];
        if ($request->explanation != '')
        {
            $rules['explanation'] = 'max:250';
        }
        if ($request->type != 5)
        {
            $rules['answer'] = 'required';
        }else{

            $rules['answer'] = 'required';
        }
        $customMessages = [
            'student_grade.required' => 'Please Provide Student Grade',
            'subject.required' => 'Please Provide Student Subject',
            'question_mark.required' => 'Please Provide Question Mark',
            'question_name.required' => 'Please Provide Question',
            'answer.required' => 'Please Provide Question Answer',
        ];
        $validator = $this->validate($request, $rules, $customMessages);

        $data = array();
        $data['question_type'] = $request->input('type');
        $data['subject'] = $request->input('subject');
        
        if(session('super_status'))
        {
            $data['user_id'] = 1;
        }else{
            $data['user_id'] = admin_id();
        }
        $data['student_grade'] = $request->input('student_grade');
        $data['question_name'] = $request->input('question_name');
        $data['question_description'] = $request->input('explanation');
        $question_type_f = 'question_type_'.$request->input('type');
        if($request->input('type') == 7)
        {
            $data['answer'] = $this->update_question_type_7($request->all(),$id);
        }else{

            $data['answer'] = $this->$question_type_f($request->all());
        }
        $data['mark'] = $request->input('question_mark');
        $data['updated_at'] = date("Y-m-d");
        
        DB::table('eyb_questions')
            ->where('id', $id)
            ->update($data);
        return redirect()->back()->with('success_message','Question Updated Successfully!');
    }
}
