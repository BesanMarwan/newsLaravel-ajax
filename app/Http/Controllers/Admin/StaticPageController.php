<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\StaticPage;

class StaticPageController extends Controller
{
    function __construct()
    {

        $this->middleware('permission:الصفحات الثابتة', ['only' => ['index']]);
        $this->middleware('permission:اضافة الصفحة', ['only' => ['create','store']]);
        $this->middleware('permission:تعديل الصفحات', ['only' => ['edit','update']]);
        $this->middleware('permission:حدف الصفحة', ['only' => ['destroy']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $staticPages = StaticPage::orderby('id', 'desc')->select('id', 'title', 'content','slug')->paginate(PAGINATION_COUNT);
        if($request->ajax()) {
            return view('admin.pages.staticPages.subs.table',compact('staticPages'));
        }
        return view('admin.pages.staticPages.index',compact('staticPages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $messages=[
            'title.required'=>'يرجى ادخال عنوان الصفحة  ..',
            'slug.required'=>'يرجى ادخال رابط  للصفحة  ..',
            'title.unique'=>' اسم هذه الصفحة موجودة مسبقا ..',
            'slug.unique'=>' رابط هذه الصفحة موجودة مسبقا ..',
            'content.required'=>'يجب ادخال محتوى للصفحة ليتم اضافتها',
        ];
        $request->validate([
            'title' => 'required|unique:static_pages|max:255',
            'content'=>'required',
            'slug'=>'required|unique:static_pages',

        ],$messages);

        try {
            //$validated = $request->validated();
            $staticPage          = new StaticPage();
            $staticPage->title   = $request->title;
            $staticPage->slug    = $request->slug;
            $staticPage->content = $request->content;
            $staticPage->save();
            if(! $staticPage ) {
                return response()->json([
                    'status' => false,
                    'error' => 'فشل عمليه اضافة الصفحة',
                ]);
            }
                return response()->json([
                    'status' => true,
                    'success' => 'تم اضافة الصفحة بنجاح',
                    'page'=>json_encode($staticPage),
                ]);
        }

        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }


    }

    public function edit(Request $request,$id)
    {
        if($request->ajax()) {
            $page = StaticPage::find($id);
            return response()->json($page);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request)
    {
       try {

            $messages=[
                'title.required'=>'يرجى ادخال عنوان الصفحة لاضافاتها ..',
                //'title.unique'=>'هذه الصفحة موجودة مسبقا ..',
               // 'content.required'=>'يجب ادخال محتوى للصفحة ليتم اضافتها',

            ];
           /* $request->validate([
                'title' => 'required|unique:static_pages|max:255',
                //'content'=>'required',
            ],$messages);*/

            $staticPage = StaticPage::findOrFail($request->id);
            $static =$staticPage->update([
                'title'   =>  $request->title,
                'content' =>$request->content,
                'slug'    => $request->slug,

            ]);
           if($static) {
               return response()->json([
                   'status' => true,
                   'success' => 'تم تعديل القسم بنجاح',
               ]);
           }
        } catch(\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage().$request->content]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request)
    {

            try {
                $staticPage = StaticPage::findOrFail($request->id)->delete();
                if (!$staticPage) {

                    return response()->json([
                        'status' => false,
                        'success' => ' فشل عمليه الحذف..:(',
                        'id' =>  $request -> id
                    ]);
                }

                return response()->json([
                    'status' => true,
                    'success' => 'تم حدف الصفحة بنجاح',
                    'id' =>  $request -> id
                ]);

            }catch(\Exception $exception){
                return redirect()->back()->withErrors(['error' => $exception->getMessage()]);

            }



    }
}
