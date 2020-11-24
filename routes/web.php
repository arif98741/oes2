<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//clear cache route
Route::get('/clear-cache', function () {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    // echo('Cache Cleared Successfully!');
    return Redirect()->route('home'); 
});
Route::get('/', 'IndexController@index')->name('home');
Route::get('thm', 'AdminController@thum');
Route::any('/logout', 'UserController@Logout')->name('logout');
Route::any('/img_to_pdf', 'UserController@img_to_pdf')->name('img_to_pdf');
Route::group(['middleware'=>['AdminMiddleware']],function(){
    Route::get('/dashboard', 'AdminController@index')->name('dashboard');
    Route::any('/manage-categories', 'PostCategories@ManageCategory')->name('manage_categories');
    Route::any('/edit-category/{id}', 'PostCategories@editCategory')->name('edit_category');
    Route::any('/manage-sub-category', 'PostCategories@manageSubCategory')->name('manage_sub_category');
    Route::any('/edit-subcategory/{id}', 'PostCategories@editSubCategory')->name('edit_subcategory');
    Route::get('/manage-posts', 'PostController@managePosts')->name('manage_posts');
    Route::any('/add-post', 'PostController@addPost')->name('add_post');
    Route::post('/search-post', 'PostController@searchPost')->name('search_post');
    Route::any('/edit-post/{id}', 'PostController@editPost')->name('edit_post');
    Route::get('/delete-post', 'PostController@deletePost');
    Route::get('/get-post-sub-categories', 'PostController@getSubCategories');


    Route::get('/manage-question', 'QuestionController@ManageQuestion')->name('manage_question');
    Route::get('/manage-question/{id}', 'QuestionController@manage_question_type')->name('manage_question_type');
    Route::get('/create-question/{id}', 'QuestionController@CreateQuestion')->name('create_question');
    Route::get('/manage-module', 'ModuleController@ManageModule')->name('manage_module');
    Route::post('/search-module', 'ModuleController@search_module')->name('search_module');
    Route::post('/exam-report', 'ExamReport@exam_report')->name('exam_report');
    Route::get('/module-report', 'ExamReport@module_report')->name('module_report');
    Route::post('/get-modules', 'ExamReport@get_modules')->name('get_modules');
    Route::post('/module-report-generate', 'ExamReport@module_report_generate')->name('module_report_generate');
    Route::post('/module-generate-pdf', 'ExamReport@module_generate_pdf')->name('module_generate_pdf');
    Route::get('/add-module', 'ModuleController@add_module')->name('add_module');
    Route::post('/add-module', 'ModuleController@add_modal_data')->name('add_modal_data');
    Route::get('/single-question-info', 'ModuleController@single_question_info')->name('single_question_info');
    Route::get('/get-question-for-module', 'ModuleController@get_question_for_module')->name('get_question_for_module');
    Route::get('/edit-module/{id}', 'ModuleController@edit_module')->name('edit_module');
    Route::get('/duplicate-module/{id}', 'ModuleController@duplicate_module')->name('duplicate_module');
    Route::post('/update-module', 'ModuleController@updateModuleData')->name('update_modal_data');
    Route::any('/manage-level', 'LevelController@manage_level')->name('manage_level');
    Route::get('/edit-level/{id}' , 'LevelController@editLevel')->name('edit_level');
    Route::post('/update-level/{id}' , 'LevelController@updateLevel')->name('update_level');
    Route::get('/get-subjects/{id}' , 'QuestionController@get_subject');
    Route::get('/edit-question/{id}' , 'QuestionController@edit_question')->name('edit_question');
    Route::post('/save-question' , 'QuestionController@save_question')->name('save_question');
    Route::post('/edit-question/{id}' , 'QuestionController@update_question')->name('update_question');
    Route::post('/question-search' , 'QuestionController@question_search')->name('question_search');
    Route::get('/manage-institute' , 'InstituteController@manageInstitute')->name('manage_institute');
    Route::any('/edit-institute/{id}' , 'InstituteController@editInstitute')->name('edit_institute');
    Route::any('/add-institute' , 'InstituteController@addInstitute')->name('add_institute');
    Route::any('/manage-subject' , 'SubjectController@manage_subject')->name('manage_subject');
    Route::get('/edit-subject/{id}' , 'SubjectController@editSubject')->name('edit_subject');
    Route::post('/update-subject/{id}' , 'SubjectController@updateSubject')->name('update_subject');
    Route::any('/manage-section' , 'SectionController@manage_section')->name('manage_section');
    Route::get('/edit-section/{id}' , 'SectionController@editSection')->name('edit_section');
    Route::post('/update-section/{id}' , 'SectionController@updateSection')->name('update_section');
    Route::any('/manage-batch' , 'BatchController@manage_batch')->name('manage_batch');
    Route::get('/edit-batch/{id}' , 'BatchController@editBatch')->name('edit_batch');
    Route::post('/update-batch/{id}' , 'BatchController@updateBatch')->name('update_batch');
    Route::any('/manage-semester' , 'SemesterController@manage_semester')->name('manage_semester');
    Route::get('/edit-semester/{id}' , 'SemesterController@editSemester')->name('edit_semester');
    Route::post('/update-semester/{id}' , 'SemesterController@updateSemester')->name('update_semester');
    Route::get('/manage-student' , 'InstituteController@manageStudent')->name('manage_student');
    Route::get('/admin/get-students-list' , 'InstituteController@manageStudentList');
    Route::get('/deactive-student/{id}' , 'InstituteController@deactiveStudent')->name('deactive_student');
    Route::get('/active-student/{id}' , 'InstituteController@activeStudent')->name('active_student');
    Route::get('exam-report' , 'ExamReport@ExamReport');
    Route::get('manage-assignment' , 'AssignmentController@manageAssignment')->name('manage_assignment');
    Route::get('add-assignment' , 'AssignmentController@addAssignment')->name('add_assignment');
    Route::post('add-assignment' , 'AssignmentController@saveAssignment')->name('save_assignment');
    // Route::post('add-assignment' , 'AssignmentController@saveAssignment')->name('save_assignment');
    Route::post('search-assignment' , 'AssignmentController@searchAssignment')->name('search_assignment');
    Route::any('edit-assignment/{id}' , 'AssignmentController@editAssignment')->name('edit_assignment');
    Route::get('assignment-view/{id}' , 'AssignmentController@assignmentView')->name('assignment_view');
    Route::get('std-answer-report/{ass_id}/{ans_id}' , 'AssignmentController@stdAnswerReport')->name('std_answer_report');
    Route::get('delete-lavel' , 'LevelController@deleteLavel');
    Route::get('delete-subject' , 'SubjectController@deleteSubject');
    Route::get('delete-semester' , 'SemesterController@deleteSemester');
    Route::get('delete-batch' , 'BatchController@deleteBatch');
    Route::get('delete-section' , 'SectionController@deleteSection');
    Route::get('delete-category' , 'PostCategories@deleteCategory');
    Route::get('delete-sub-category' , 'PostCategories@deleteSubCategory');
    Route::get('delete-contact' , 'AdminController@deleteContact');
    Route::get('admin/users' , 'AdminController@users')->name('admin.users');
    Route::any('admin/users-list' , 'AdminController@user_list')->name('admin.user_list');
    Route::post('admin/search-user' , 'AdminController@search_user')->name('admin.search_user');
    Route::get('admin/get-users-list' , 'AdminController@get_users_list')->name('admin.get_users_list');
    Route::any('admin/edit-user' , 'AdminController@edit_user')->name('admin.edit_user');
    Route::get('admin/contact' , 'AdminController@contact')->name('admin.contact');
    Route::get('admin/members' , 'AdminController@members')->name('admin.members');
    Route::any('admin/add-member' , 'AdminController@add_member')->name('admin.add_member');
    Route::get('admin/get-members-list' , 'AdminController@get_members_list')->name('admin.get_members_list');

});

//institute
// Route::any('/institute' , 'InstituteController@Institute')->name('institute_login');

// Route::get('welcome', 'QuestionController@ManageQuestion');


//Route::get('/create-question', 'QuestionController@CreateQuestion')->name('create_question');

Route::group(['middleware'=>['StudentMiddleware']],function(){

    //front end
Route::get('user/dashboard', 'UserController@dashboard')->name('user.dashboard');
Route::get('/create-module', 'ModuleController@create_module')->name('create_module');
Route::get('/get-total-question/{id}' , 'QuestionController@get_total_question');
Route::post('/create-module' , 'ModuleController@store_module')->name('store_module');
Route::get('/module' , 'ModuleController@module')->name('module');
Route::get('/tutor-module' , 'ModuleController@tutor_module')->name('tutor_module');
Route::get('/get-module' , 'ModuleController@get_module')->name('get_module');
Route::get('/student-score' , 'ModuleController@student_score')->name('student_score');
Route::post('/search-student-answer' , 'ModuleController@search_student_answer')->name('search_student_answer');
Route::get('/exam-progress/{progress_id}' , 'ModuleController@exam_progress')->name('exam_progress');
Route::post("search-user-module",'ModuleController@searchUserModule')->name('search_user_module');
//user profile
Route::get('/profile' , 'UserController@profile')->name('profile');
Route::post('/update-user-info' , 'UserController@update_user_info')->name('update_user_info');
Route::post('/change-user-password' , 'UserController@change_user_password')->name('change_user_password');
Route::post('/update-picture' , 'UserController@update_picture')->name('update_picture');

//student answer matching
Route::get('/student-examination/{module_id}','ExamController@student_examination')->name('student_examination');
Route::post('/answer-submit/{module_id}','ExamController@answer_submit')->name('answer_submit');
Route::get('/show-examination-answer/{module_id}','ExamController@show_examination_answer')->name('show_examination_answer');
Route::get('/answet-downlaod/{module_id}','ExamController@answet_downlaod')->name('answet_downlaod');
Route::get('/student-exam/{module_id}/{question_id}/{order}' , 'ExamController@student_exam')->name('student_exam');
Route::get('/tutor-exam/{module_id}/{question_id}/{order}' , 'ExamController@tutor_exam')->name('tutor_exam');
Route::get('/ajax-student-exam/{module_id}/{question_id}/{order}' , 'ExamController@ajax_student_exam')->name('ajax_student_exam');
Route::post('/std-true-false' , 'ExamController@std_true_false')->name('std_true_false');
Route::post('/std-answer-matching' , 'ExamController@std_answer_matching')->name('std_answer_matching');
Route::get('/show-result/{module_id}' , 'ExamController@show_result')->name('show_result');
Route::get('/practice-module' , 'ModuleController@practice_module')->name('practice_module');
Route::post('/search-subject-by-inst' , 'ModuleController@search_subject_by_inst')->name('search_subject_by_inst');
Route::post('/search-level-by-inst' , 'ModuleController@search_level_by_inst')->name('search_level_by_inst');
Route::post('/search-subject-by-level' , 'ModuleController@search_subject_by_level')->name('search_subject_by_level');
Route::get('/institute-exam-module' , 'ModuleController@institute_exam_module')->name('institute_exam_module');
Route::post('/search-exam-module' , 'ModuleController@Search_exam_module')->name('search_exam_module');
Route::post('/search-practice-module' , 'ModuleController@search_practice_module')->name('search_practice_module');
Route::get('/search-practice-module' , 'ModuleController@search_practice_module_list')->name('search_practice_module_list');
Route::get('/search-exam-module' , 'ModuleController@search_exam_module_list')->name('search_exam_module_list');

Route::get('/institute-registration', 'InstituteController@institute_registration')->name('institute_registration');
Route::get('/undergraduate', 'InstituteController@Undergraduate')->name('undergraduate');
Route::get('/university', 'InstituteController@University')->name('university');
Route::get('/others', 'InstituteController@Others')->name('others');
Route::get('/institute-level/{id}' , 'InstituteController@institute_level');
Route::get('/institute-batch/{id}' , 'InstituteController@institute_batch');
Route::get('/institute-section/{id}' , 'InstituteController@institute_section');
Route::get('/institute-semester/{id}' , 'InstituteController@institute_semester');
Route::post('/undergraduate' , 'InstituteController@institute_register')->name('institute_register');
Route::post('/university' , 'InstituteController@university_register')->name('university_register');
Route::post('/others' , 'InstituteController@others_register')->name('others_register');
Route::get('/student-institute' , 'InstituteController@institute_profile')->name('student_institute');
Route::post('student-institute' , 'InstituteController@update_institute_profile')->name('update_institute_profile');
Route::get('remove-institute/{id}' , 'InstituteController@remove_institute')->name('remove_institute');
Route::get('tutor-assignment' , 'AssignmentController@tutorAssignment')->name('tutor_assignment');
Route::get('assignment-exam/{id}' , 'AssignmentController@assignmentExam')->name('assignment_exam');
Route::post('assignment-exam' , 'AssignmentController@assignmentSubmit')->name('assignment_submit');
Route::post('search-student-assignment' , 'AssignmentController@search_student_assignment')->name('search_student_assignment');
});

// student login
Route::any('/login', 'UserController@UserLogin')->name('login');
Route::any('/register', 'UserController@UserRegister')->name('register');
Route::any('/forgot-password', 'UserController@forgot_password')->name('forgot_password');
Route::any('contact', 'UserController@contact')->name('contact');
Route::get('how-to-use', 'IndexController@how_to_use')->name('how_to_use');
Route::any('study', 'BookController@Index')->name('study');
Route::post('filter-study', 'BookController@filter_study')->name('filter_study');
Route::post('study-pagination', 'BookController@study_pagination')->name('study_pagination');
Route::get('verify-email/{code}', 'UserController@verify_email')->name('verify_email');
//admin login
Route::any('/backend' , 'AdminController@Login')->name('backend');
Route::get('/admin-logout' , 'AdminController@admin_logout')->name('admin_logout');

//blog route
Route::get('blog' , 'BlogController@Index')->name('blog');
Route::get('category/{id}' , 'BlogController@categoryPost')->name('category');
Route::get('subcategory/{id}' , 'BlogController@subcategoryPost')->name('subcategory');
Route::get('post/{slug}' , 'BlogController@Post')->name('post');
Route::get('search' , 'BlogController@search')->name('search');
Route::post('search' , 'BlogController@searchPost')->name('search');