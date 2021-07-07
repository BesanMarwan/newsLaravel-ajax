<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:الاقسام',    ['only' => ['index']]);
        $this->middleware('permission:اضافة قسم', ['only' => ['store']]);
        $this->middleware('permission:تعديل قسم', ['only' => ['update']]);
        $this->middleware('permission:حذف قسم',   ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $categories = Category::orderby('id', 'desc')->select('id', 'name', 'description')->paginate(PAGINATION_COUNT);
        if($request->ajax()) {
            return view('admin.pages.categories.sub.table',compact('categories'));
        }
        return view('admin.pages.categories.index',compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $messages=[
            'name.required'=>'يرجى ادخال اسم القسم لاضافته ..',
            'name.unique'=>'هذا القسم موجود مسبقا ..',
        ];
        $request->validate([
            'name' => 'required|unique:categories|max:255',
        ],$messages);
        try {
            //$validated = $request->validated();
            $category              = new Category();
            $category->name        = $request->name;
            $category->description = $request->description;
            $category->save();
//            return message with ajax
            if (! $category)
                return response()->json([
                    'status' => false,
                    'error' => 'فشل عمليه اضافة القسم',
                ]);

            return response()->json([
                'status' => true,
                'success' => 'تم اضافة القسم القسم بنجاح',
                'category'=>json_encode($category),
            ]);
        }
        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }
    public function show($id)
    {
        $category = Category::find($id);
        return response()->json($category);
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
                'name.required'=>'يرجى ادخال اسم القسم لاضافته ..',
                'name.unique'=>'هذا القسم موجود مسبقا ..',
            ];
            $request->validate([
                'name' => 'required',
            ],$messages);

            $category = Category::findOrFail($request->id);
            $cat =$category->update([
                'name'        =>  $request->name,
                'description' => $request->description,
            ]);
            if($cat) {
                $category=Category::select('id','name','description')->where('id',$request->id)->first();
                return response()->json([
                    'status' => true,
                    'success' => 'تم تعديل القسم بنجاح',
                    'category' => json_encode($category),
                ]);
            }
        }
        catch
        (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
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
                $category = category::findOrFail($request->id);

                if($category->posts()->count() == 0){
                    $category->delete();
                    return response()->json([
                        'status' => true,
                        'success' => 'تم حدف القسم بنجاح',
                        'id' =>  $request -> id
                    ]);

                }else {
                    return response()->json([
                        'status' => false,
                        'error' => 'فشل حدف القسم لوجود اخبار تنتمي اليه ',
                        'id' => $request->id

                    ]);
                }


            }
            catch(\Exception $exception){

                return response()->json([
                    'status' => false,
                    'error' => $exception->getMessage(),
                ]);
            }

    }
}

?>
