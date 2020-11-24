<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PostCategory;
use App\PostSubCategory;
use App\Post;
use DB;
class BlogController extends Controller
{
    public function Index()
    {
    	$data = array();
    	$data['categories'] = PostCategory::all();
    	$data['recent_posts'] = DB::table('posts')
                        ->leftJoin('post_categories', 'posts.category', '=', 'post_categories.id')
                        ->leftJoin('post_sub_categories', 'posts.sub_category', '=', 'post_sub_categories.id')
                        ->select('posts.*','post_categories.category_name','post_sub_categories.sub_categoy_name')
                        ->where('post_status',1)
                        ->orderBy('id','DESC')
                        ->paginate(6);
    	return view('blog.home',$data);
    }

    public function categoryPost($id)
    {
        if(!is_numeric($id))
        {
            return redirect()->route('blog');
        }
        $category = PostCategory::where('id',$id)->first();
        $category_posts  = DB::table('posts')
                            ->leftJoin('post_categories', 'posts.category', '=', 'post_categories.id')
                            ->leftJoin('post_sub_categories', 'posts.sub_category', '=', 'post_sub_categories.id')
                            ->select('posts.*','post_categories.category_name','post_sub_categories.sub_categoy_name')
                            ->where('posts.category',$id)
                            ->orderBy('id','DESC')
                            ->paginate(6);
        return view('blog.category',['category_posts'=>$category_posts,'category'=>$category]);
    }
    public function subcategoryPost($id)
    {
        if(!is_numeric($id))
        {
            return redirect()->route('blog');
        }
        $subcategory = PostSubCategory::where('id',$id)->first();
        $posts  = DB::table('posts')
                            ->leftJoin('post_categories', 'posts.category', '=', 'post_categories.id')
                            ->leftJoin('post_sub_categories', 'posts.sub_category', '=', 'post_sub_categories.id')
                            ->select('posts.*','post_categories.category_name','post_sub_categories.sub_categoy_name')
                            ->where('posts.sub_category',$id)
                            ->orderBy('id','DESC')
                            ->paginate(6);
        return view('blog.subcategory',['posts'=>$posts,'subcategory'=>$subcategory]);
    }

    public function Post($slug)
    {
        $data['post'] = '';
        if($post = Post::where('slug',$slug)->first())
        {
            $post->views = $post->views+1;
            $post->update();
            $data['post']  = DB::table('posts')
                    ->leftJoin('post_categories', 'posts.category', '=', 'post_categories.id')
                    ->leftJoin('post_sub_categories', 'posts.sub_category', '=', 'post_sub_categories.id')
                    ->select('posts.*','post_categories.category_name','post_sub_categories.sub_categoy_name')
                    ->where('posts.slug',$slug)
                    ->first();
        }
        $data['categoires'] = PostCategory::all();
        $data['populers'] = Post::orderBy('views','DESC')->take(5)->get();
        return view('blog.post',$data);
    }

    public function search()
    {
        $data = array();
        $data['posts'] = DB::table('posts')
                        ->leftJoin('post_categories', 'posts.category', '=', 'post_categories.id')
                        ->leftJoin('post_sub_categories', 'posts.sub_category', '=', 'post_sub_categories.id')
                        ->select('posts.*','post_categories.category_name','post_sub_categories.sub_categoy_name')
                        ->where('post_status',1)
                        ->orderBy('id','DESC')
                        ->take(6)
                        ->get();
        return view('blog.search',$data);
    }

    public function searchPost(Request $request)
    {
        $posts = DB::table('posts')
                        ->leftJoin('post_categories', 'posts.category', '=', 'post_categories.id')
                        ->leftJoin('post_sub_categories', 'posts.sub_category', '=', 'post_sub_categories.id')
                        ->select('posts.*','post_categories.category_name','post_sub_categories.sub_categoy_name')
                        ->where('posts.post_title','like','%'.$request->search.'%')
                        ->orWhere('posts.content','like','%'.$request->search.'%')
                        ->orderBy('id','DESC')
                        ->take(20)
                        ->get();
        if(count($posts) > 0)
        {
            $view =  view('blog.search-content',['posts'=>$posts]);
            $result['view'] = $view->render();
        }else{
            $result['view'] = 'NO POST FOUND!';
        }
        return response()->json($result);
    }
}
