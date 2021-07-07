<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Models\Post;
use App\Models\PostMedia;
use App\Models\Category;
use DB;
use App\Http\Requests\PostRequest;
use PhpParser\Node\Stmt\Else_;


class PostsController extends Controller
{
    function __construct()
    {

        $this->middleware('permission:الاخبار', ['only' => ['index']]);
        $this->middleware('permission:اضافة خبر', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل الاخبار', ['only' => ['edit','update']]);
        $this->middleware('permission:حدف خبر', ['only' => ['delete']]);

    }

    public function index(Request $request){
        $posts = Post::orderby('id', 'desc')->select('id','slug', 'title','content','meta_data','comment_able','category_id','viewer_count')->with(['media','category'])->paginate(PAGINATION_COUNT);
        if($request->ajax()) {
            return view('admin.pages.posts.subs.table',compact('posts'));
        }
        $categories= Category::select('id','name')->get();
        return view('admin.pages.posts.index',compact('categories','posts'));
    }

    public function edit(Request $request,$id){
        if($request->ajax()) {
            $posts = Post::where('id', $id)->with(['category', 'media'])->get();
            return response()->json($posts);
        }

    }

    public function store(PostRequest $request){

       try{
//         $validated = $request->validated();
        //Store the post info
        DB::beginTransaction();
        $post               = new Post();
        $post->title        = $request->title;
        $post->slug         =str_replace(' ','-',$request->title);
        $post->content      = $request->content;
        $post->meta_data    = $request->meta_data;
        $post->comment_able = $request->comment_able;
        $post->category_id  = $request->category;
        $post->user_id      =auth()->user()->id;
        $post->save();


////        // maintain the photo and save it
        if ($request->has('image')) {
            $file     = $request->file('image');
            $filePath = uploadImage('posts', $file);
            $fileAlt = $request->alt;
            //save image
            $image= $post->media()->create([
                'file_name' => $filePath,
                'alt'       => str_replace('"','',$fileAlt),
                'file_size' => $file->getSize(),
                'file_type' => $file->getMimeType(),
            ]);

            if($image){
                DB::commit();
            }
            else{
                DB::rollback();
            }
        }
        else
            return response()->json([
                'status' => false,
                'error'  =>' لا يوجد صوره :( ',
            ]);

        if(! $post )
            return response()->json([
                'status' => false,
                'error'  =>' فشل عملية اضافة الخبر :( ',
            ]);


           return response()->json([
               'status' => true,
               'success' => 'تم اضافة  الخبر بنجاح',
           ]);
         } catch (\Exception $e){
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
         }
    }



    public function update(PostRequest $request){
        try {
            //Store the post info
            $post = Post::findOrFail($request->id);
            $post->update([
            'title'        => $request->title,
            'slug'         =>str_replace(' ','-',$request->title),
            'content'      => $request->content,
            'meta_data'    => $request->meta_data,
            'comment_able' => $request->comment_able,
            'category_id'  => $request->category,
            'user_id'      =>auth()->user()->id,
                                ]);
            // maintain the photo and save it
            if ($request->has('image')) {
                DB::beginTransaction();
                $file     =$request->file('image');
                $filePath =uploadImage('posts', $file);
                $fileAlt  =$request->img_title;
                //save image
                $image=$post->media()->create([
                'file_name' => $filePath,
                'alt'       => str_replace('"','',$fileAlt),
                'file_size' => $file->getSize(),
                'file_type' => $file->getMimeType(),
                ]);
                if($image){
                    DB::commit();
                }
                else{
                    DB::rollback();

                }
            }

            if(! $post ){
                return response()->json([
                    'status' => false,
                    'error' => 'فشل عملية تعديل الخبر :(',
                ]);
            }

            return response()->json([
                'status' => true,
                'success' => 'تم تعديل الخبر بنجاح',
            ]);
        }

        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function delete(Request $request){
         try {
        $post = Post::findOrFail($request->id);
        if (!$post) {
            return response()->json([
                'status' => false,
                'error' => 'فشل عمليه  حدف الخبر ',
            ]);
        }
        /// to delete image from folder
             foreach($post->media as $media) {
                 $image = public_path($media->file_name);
                 unlink($image);
             }

        $post->delete();
             return response()->json([
                 'status' => true,
                 'success' => 'تم حدف الخبر بنجاح',
                 'id' =>  $request -> id
             ]);

      }catch(\Exception $exception){
        return redirect()->back()->withErrors(['error' => $exception->getMessage()]);

       }
    }


}
