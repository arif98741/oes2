<?php

use App\InstituteStudent;
use App\PostSubCategory;
use App\PostCategory;
use App\StartModule;
    function imploadValue($types){
        $strTypes = implode(",", $types);
        return $strTypes;
    }

    function explodeValue($types){
        $strTypes = explode(",", $types);
        return $strTypes;
    }
    function get_module_start_time($module_id)
    {
        $start_time = StartModule::where('std_id',user_id())->where('module_id',$module_id)->first();
        if($start_time != false)
        {
            return $start_time->start_time;
        }
        return false;
    }
    function random_code(){

        echo rand(1111, 9999);
    }
    function admin_id()
    {
        // $get_session = ;
        // $get_session = session('log_status');
        // $user = DB::table('eyb_users')
        //     ->where('log',$get_session)
        //     ->first();
        // $user_id = $user->id;
        return session('admin_id');
    }
    function user_info()
    {
        $get_session = session('user_id');
        $user = DB::table('eyb_users')
            ->where('id',$get_session)
            ->first();
        return $user;
    }
    function user_id()
    {
        // $get_session = session('user_id');
        // $user = DB::table('eyb_users')
        //     ->where('id',$get_session)
        //     ->first();
        // $user_id = $user->id;
        return session('user_id');
    }
    function admin_type()
    {
        $get_session = session('admin_id');
        $user = DB::table('eyb_users')
            ->where('id',$get_session)
            ->first();
        $user_type = $user->user_type;
        return $user_type;
    }
    function get_levels($id)
    {
        return DB::table('eyb_level')->where('user_id',$id)->get();
    }
    function get_batches($id,$level)
    {
        return DB::table('student_batches')->where('user_id',$id)->where('level_id',$level)->get();
    }
    function get_semesters($id)
    {
        return DB::table('semesters')->where('level_id',$id)->get();
    }
    function get_sections($id)
    {
        return DB::table('sections')->where('level_id',$id)->get();
    }
    function QuestionTypeCount($type)
    {
        $tutor_id = admin_id();
        if(session('super_status'))
        {
            $tutor_id = 1;
        }
        $questions = DB::table('eyb_questions')
            ->select(DB::raw('count(id) as count'))
            ->where('question_type',$type)
            ->where('user_id',$tutor_id)
            ->get();
        return $questions[0]->count;
    }
    function haveInstituteStudent()
    {
        $info =  InstituteStudent::where('user_id',user_id())->first();
        
        return  $info;
    }
    function StudentInstitute($std_id)
    {
        $info = DB::table('institute_students')
                    ->leftJoin('eyb_users', 'institute_students.institute_id', '=', 'eyb_users.id')
                    ->where('institute_students.user_id',$std_id)
                    ->select('eyb_users.name')
                    ->first();
        return  $info;
    }
    function is_active()
    {
        $info =  InstituteStudent::select('status')->where('user_id',user_id())->where('status',1)->first();
        
        if($info != false)
        {
            return  1;
        }else
        {
           return  0; 
        }
        
    }
    function get_sub_categories()
    {
       return  $sub_categories = PostSubCategory::all();
    }
    function get_categories()
    {
       return  $categories = PostCategory::all();
    }
    function remove_special_char($text) {

        $t = $text;

        $specChars = array(
            ' ' => '-',    '!' => '',    '"' => '',
            '#' => '',    '$' => '',    '%' => '',
            '&amp;' => '',    '\'' => '',   '(' => '',
            ')' => '',    '*' => '',    '+' => '',
            ',' => '',    '₹' => '',    '.' => '',
            '/-' => '',    ':' => '',    ';' => '',
            '<' => '',    '=' => '',    '>' => '',
            '?' => '',    '@' => '',    '[' => '',
            '\\' => '',   ']' => '',    '^' => '',
            '_' => '',    '`' => '',    '{' => '',
            '|' => '',    '}' => '',    '~' => '',
            '-----' => '-',    '----' => '-',    '---' => '-',
            '/' => '',    '--' => '-',   '/_' => '-',

        );

        foreach ($specChars as $k => $v) {
            $t = str_replace($k, $v, $t);
        }

        return $t;
    }