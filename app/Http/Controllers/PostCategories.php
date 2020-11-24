<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PostCategory;
use App\PostSubCategory;
use DB;
use Image;
class PostCategories extends Controller
{
     public function ManageCategory(Request $request)
	    {
	    	$admin_id = admin_id();
	        $data = array();
	        if ($request->isMethod('post')) {
	                $validatedData = $request->validate([
	                    'category_name' => 'required|max:100',
	                    'category_image' => 'required|file|mimes:jpeg,jpg,png',
	                ]);
	                $category = new PostCategory();
	                if ($request->file('category_image')) {

		                $image 				= $request->file('category_image');
		                $image_name 		= time().'_'.rand(10000,9999999).'.'.$image->getClientOriginalExtension();
		                $destinationPath 	= 'public/assets/post_categories';
		                $image->move($destinationPath,$image_name);
		                $file_path 			= "assets/post_categories/".$image_name;
             // Image::make($file_path)->widen(960)->heighten(960)->orientate()->crop(960,960)->save($destinationPath.'/'.$image_name);
             Image::make('public/'.$file_path)->resize(950,350, function($constraint){
                  $constraint->aspectRatio();
                 })->save($destinationPath.'/'.$image_name);
		                $category->image 	= $file_path;
		            }
	                $category->category_name 	= $request->category_name;
	                $category->user_id 			= $admin_id;
	                if($category->save())
	                {
	                	return redirect()->back()->with('success','Added successfully.');
	                }else{

	                	return redirect()->back()->with('error','Added Failed');
	                }
	                
	        }
	        $data['categories'] = PostCategory::where('user_id',$admin_id)->get();
	        return view('admin.posts.categories.categories',$data);
	    }

	    public function editCategory(Request $request, $id)
	    {
	    	$admin_id   = admin_id();
	    	$category   = PostCategory::where('id',$id)->first();
	    	if ($request->isMethod('post')) {

	    		$validatedData = $request->validate([
	                    'category_name'  => 'required|max:100',
	                    'category_image' => 'file|mimes:jpeg,jpg,png',
	                ]);
	    			if ($request->file('category_image')) {

		                $image 				= $request->file('category_image');
		                $image_name 		= time().'_'.rand(10000,9999999).'.'.$image->getClientOriginalExtension();
		                $destinationPath    = 'public/assets/post_categories';
		                $image->move($destinationPath,$image_name);
		                $file_path 			= "assets/post_categories/".$image_name;
		                // Image::make($file_path)->widen(960)->heighten(960)->orientate()->crop(960,960)->save($destinationPath.'/'.$image_name);
		                Image::make('public/'.$file_path)->resize(950,350, function($constraint){
                  $constraint->aspectRatio();
                 })->save($destinationPath.'/'.$image_name);
		                $path = base_path()."/public/".$category->image;
		                if($category->image != '')
		                {
		                	if (file_exists($path)) {
			                	unlink($path);
			            	}
		                }
		                $category->image 	= $file_path;
		            }
	                $category->category_name 	= $request->category_name;
	                if($category->update())
	                {
	                	return redirect()->back()->with('success','Update successfull.');
	                }else{

	                	return redirect()->back()->with('error','Update Failed');
	                }
	    	}
	        
	        return view('admin.posts.categories.edit-category',['category'=>$category]);
	    }

	    public function manageSubCategory(Request $request)
	    {
	    	$admin_id = admin_id();
	        $data = array();
	        if ($request->isMethod('post')) {

	                $validatedData = $request->validate([
	                    'category_id' 		=> 'required|numeric',
	                    'sub_categoy_name' 	=> 'required|max:100',
	                ]);
	                $sub_category = new PostSubCategory();
	                $sub_category->category_id 		= $request->category_id;
	                $sub_category->sub_categoy_name = $request->sub_categoy_name;
	                $sub_category->user_id 			= $admin_id;
	                if($sub_category->save())
	                {
	                	return redirect()->back()->with('success','Added successfully.');
	                }else{

	                	return redirect()->back()->with('error','Added Failed');
	                }
	                
	        }
	        $data['categories'] = PostCategory::where('user_id',$admin_id)->get();
	        $data['sub_categories'] = DB::table('post_sub_categories')
                        ->leftJoin('post_categories', 'post_sub_categories.category_id', '=', 'post_categories.id')
                        ->select('post_sub_categories.*','post_categories.category_name')
                        ->where('post_sub_categories.user_id',$admin_id)
                        ->get();
	        return view('admin.posts.sub-categories.sub-categories',$data);
	    }

	    public function editSubCategory(Request $request,$id)
	    {
	    	$sub_category = PostSubCategory::where('id',$id)->first();
	    	$admin_id = admin_id();
	        $data = array();
	        if ($request->isMethod('post')) {

	                $validatedData = $request->validate([
	                    'category_id' 		=> 'required|numeric',
	                    'sub_categoy_name' 	=> 'required|max:100',
	                ]);
	                
	                $sub_category->category_id 		= $request->category_id;
	                $sub_category->sub_categoy_name = $request->sub_categoy_name;
	               
	                if($sub_category->update())
	                {
	                	return redirect()->back()->with('success','Update successfull.');
	                }else{

	                	return redirect()->back()->with('error','Update Failed');
	                }
	                
	        }
	        $data['categories'] = PostCategory::where('user_id',$admin_id)->get();
	        $data['sub_categories'] = DB::table('post_sub_categories')
                        ->leftJoin('post_categories', 'post_sub_categories.category_id', '=', 'post_categories.id')
                        ->select('post_sub_categories.*','post_categories.category_name')
                        ->where('post_sub_categories.user_id',$admin_id)
                        ->get();
            $data['sub_category'] = $sub_category;
	        return view('admin.posts.sub-categories.edit-sub-categories',$data);
	    }
	public function deleteCategory(Request $request)
    {
        $id = $request->id;
       
        if(PostCategory::where('id',$id)->delete())
        {
            echo 1;
        }else
        {
            echo 0;
        }
    }
    public function deleteSubCategory(Request $request)
    {
        $id = $request->id;
       
        if(PostSubCategory::where('id',$id)->delete())
        {
            echo 1;
        }else
        {
            echo 0;
        }
    }
}
