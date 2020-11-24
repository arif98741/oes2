<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PostCategory;
use App\PostSubCategory;
use App\Post;
use Validator;
use DB;
use Image;
class PostController extends Controller
{
	public function addPost(Request $request)
	{
		$admin_id = admin_id();
		if ($request->isMethod('post')) {

			
			$validatedData = $request->validate([
	                    'post_title' 	=> 'required',
	                    'category' 		=> 'required|numeric',
	                    'sub_category' 	=> 'required|numeric',
	                    'content' 		=> 'required',
	                    'slug' 			=> 'required|unique:posts,slug',
	                    'post_status' 	=> 'required|numeric',
	                    'image' 		=> 'required|file|mimes:jpeg,jpg,png',
	                ]);
			$str = str_replace(" ","-",strtolower($request->slug));
			
			$post = new Post();
			$post->post_title 		= $request->post_title;
			$post->category 		= $request->category;
			$post->sub_category 	= $request->sub_category;
			$post->content 			= $request->content;
			$post->post_status 		= $request->post_status;
			$post->slug 			= $str;
			$post->user_id 			= $admin_id;
			if ($request->file('image')) {

                $image 				= $request->file('image');
                $image_name 		= time().'_'.rand(10000,9999999).'.' . $image->getClientOriginalExtension();
                $destinationPath 	= 'public/assets/post_images';
                $image->move($destinationPath,$image_name);
                $file_path 			= "assets/post_images/" . $image_name;
                Image::make('public/'.$file_path)->widen(350)->heighten(250)->orientate()->crop(350,250)->save($destinationPath.'/'.$image_name);
                $post->image 				= $file_path;

            }
			if($post->save())
	            {
	            	return redirect()->back()->with('success','Added successfully.');
	            }else{

	            	return redirect()->back()->with('error','Added Failed');
	            }
		}
    	$data['categories'] = PostCategory::where('user_id',$admin_id)->get();
    	$data['subcategories'] = PostSubCategory::where('user_id',$admin_id)->get();

    	return view('admin.posts.post',$data);
	}

	public function searchPost(Request $request)
	{
		$validator = Validator::make($request->all(), [

                'category_id'        => 'required|numeric',
                'sub_category'       => 'required|numeric',

            ]);
		if ($validator->passes()) {

			$condition = array();
            if ($request->category_id != '')
            {
                $condition['posts.category'] = $request->category_id;
            }
            if ($request->sub_category != '')
            {
                $condition['posts.sub_category'] = $request->sub_category;
            }
            $user_id    = admin_id();
            $user_type  = admin_type();
            $condition['posts.user_id'] = $user_id;
            if($request->post_title)
            {
            	$posts = DB::table('posts')
                        ->leftJoin('post_categories', 'posts.category', '=', 'post_categories.id')
                        ->leftJoin('post_sub_categories', 'posts.sub_category', '=', 'post_sub_categories.id')
                        ->select('posts.*','post_categories.category_name','post_sub_categories.sub_categoy_name')
                        ->where($condition)
                        ->where('post_title','like','%'.$request->post_title.'%')
                        ->orderBy('id','DESC')
                        ->get();
            }else
            {
            	$posts = DB::table('posts')
                        ->leftJoin('post_categories', 'posts.category', '=', 'post_categories.id')
                        ->leftJoin('post_sub_categories', 'posts.sub_category', '=', 'post_sub_categories.id')
                        ->select('posts.*','post_categories.category_name','post_sub_categories.sub_categoy_name')
                        ->where($condition)
                        ->orderBy('id','DESC')
                        ->get();
            }
            
            $count = count($posts);
            if ($count > 0)
            {
                $html = '';
                foreach($posts as $post)
                {
                    $html .= '<tr>';
                    $html .= '<td>'.$post->post_title.'</td>';
                    $html .= '<td>'.$post->category_name.'</td>';
                    $html .= '<td>'.$post->sub_categoy_name.'</td>';
                    $html .= '<td ><a class="btn btn-primary" target="_blank" href="'.route('edit_post',$post->id).'">Edit</a> <a class="btn btn-danger delete-btn" href="#" onclick="DeletePost('.$post->id.')">delete</a></td>';
                    $html .= '</tr>';
                }
                return response()->json(['success'=>$html]);
            }else
            {
                return response()->json(['success'=>'No data found!']);
            }

		}else{
            return response()->json(['error'=>$validator->errors()->all()]);
        }
		
	}

    public function deletePost(Request $request)
    {
        $id = $request->id;
        $post = Post::where('id',$id)->first();
        if($post->delete())
        {
            echo 1;
        }else
        {
            echo 0;
        }
        
    }

    public function getSubCategories(Request $request)
    {
        $id = $request->id;
        $admin_id = admin_id();
        $sub_cats =  PostSubCategory::where('user_id',$admin_id)->where('category_id',$id)->get();
        $html = '<option>Select Subcategory</option>';

        if(count($sub_cats) > 0)
        {
            foreach ($sub_cats as $key => $value) {
                
                $html .= '<option value="'.$value->id.'">'.$value->sub_categoy_name.'</option>';
            }
        }
        
        echo json_encode($html);
    }
    public function managePosts()
    {
    	$admin_id = admin_id();
    	$data['categories'] = PostCategory::where('user_id',$admin_id)->get();
    	$data['subcategories'] = PostSubCategory::where('user_id',$admin_id)->get();

    	return view('admin.posts.posts',$data);
    }
    public function editPost(Request $request,$id)
    {
    	$admin_id 	= admin_id();
    	$post 		= Post::where('id',$id)->where('user_id',$admin_id)->first();
		if ($request->isMethod('post')) {

			
			$validatedData = $request->validate([
	                    'post_title' 	=> 'required',
	                    'category' 		=> 'required|numeric',
	                    'sub_category' 	=> 'required|numeric',
	                    'content' 		=> 'required',
	                    'slug' 			=> 'required',
	                    'post_status' 	=> 'required|numeric',
	                    'image' 		=> 'file|mimes:jpeg,jpg,png',
	                ]);
			$str = str_replace(" ","-",strtolower($request->slug));
			
			$post->post_title 		= $request->post_title;
			$post->category 		= $request->category;
			$post->sub_category 	= $request->sub_category;
			$post->content 			= $request->content;
			$post->post_status 		= $request->post_status;
			$post->slug 			= $str;

			if ($request->file('image')) {

                $image 				= $request->file('image');
                $image_name         = time().'_'.rand(10000,9999999).'.' . $image->getClientOriginalExtension();
                $destinationPath    = 'public/assets/post_images/';
                $image->move($destinationPath,$image_name);
                $file_path          = "assets/post_images/" . $image_name;
                Image::make('public'.$file_path)->widen(350)->heighten(250)->orientate()->crop(350,250)->save('assets/post_images/'.$image_name);
                $path = base_path()."/".$post->image;
                if($post->image != '')
                {
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
                $post->image                = $file_path;
            }
			if($post->update())
	            {
	            	return redirect()->back()->with('success','Update successfully.');
	            }else{

	            	return redirect()->back()->with('error','Update Failed');
	            }
		}
    	$data['post'] = $post;
    	$data['categories'] = PostCategory::where('user_id',$admin_id)->get();
    	$data['subcategories'] = PostSubCategory::where('user_id',$admin_id)->get();

    	return view('admin.posts.edit-post',$data);
    }
}
