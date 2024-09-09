<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\KnowledgeBase; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class KnowledgeBaseController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::all();

        if ($request->ajax()){
            $query = KnowledgeBase::with('department','user');
            if ($request->has('kbCategory') && $request->kbCategory != 'all'){
                $data = $query->where('department_id','=',$request->kbCategory);
            }elseif ($request->has('kbPinned') && $request->kbPinned != 'all'){
                $data = $query->where('pinned','=',$request->kbPinned);
            }elseif ($request->has('kbStatus') && $request->kbStatus != 'all'){
                $data = $query->where('status','=',$request->kbStatus);
            }else{
                $data = $query;
            }

            return DataTables::of($data)
                ->addColumn('content', function ($data){
                    return strip_tags(str_limit($data->content, 40));
                })
                ->addColumn('category', function ($data) {
                    return optional($data->department)->title;
                })
                ->addColumn('pinned_status', function ($data){
                    if ($data->pinned){
                        $checked = 'checked';
                    }else{
                        $checked = '';
                    }
                    $val = '<div class="switchToggle">
                                        <input type="checkbox" class="pinned-class" id="switch-'.$data->id.'" data-id="'.$data->id.'"'.$checked.'>
                                        <label for="switch-'.$data->id.'" data-id="'.$data->id.'">Toggle</label>
                                    </div>';
                    return $val;
                })->addColumn('kb_status', function ($data){
                    if($data->status == 0){
                        return '<span class="badge badge-warning">'.__('theme.unpublished').'</span>';
                    }else{
                        return '<span class="badge badge-success">'.__("theme.published").'</span>';
                    }
                })
                ->addColumn('created_by', function ($data){
                    return $data->user->name;
                })
                ->addColumn('action', function ($data){
                    $editRoute = route('knowledge-base-edit.edit', $data->id);
                    $value = '<a href="'.$editRoute.'" class="btn btn-primary btn-sm" title="Edit"><i class="fa fa-pencil"></i> </a>
                              <button type="button" data-id="'.$data->id.'" data-toggle="modal" data-target="#DeleteDataModal" class="btn btn-danger btn-sm" id="getDataDeleteId" title="Delete"><i class="la la-trash-o"></i></button>';

                    return $value;
                })
                ->rawColumns(['pinned_status','kb_status','action'])->make(true);
        }

        return view('kb.index', compact('departments'));
    }

    public function create()
    {
        $departments = Department::all();

        return view('kb.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'department' => 'required',
            'title' => 'required',
            'content' => 'required',
        ]);

        $department = $request->department;
        $title = $request->title;
        $content = clean($request->content);
        $status = $request->status;

        $created = KnowledgeBase::create([
                'department_id' => $department,
                'title' => $title,
                'content' => $content,
                'status' => $status,
                'user_id' => Auth::id(),
            ]);

        if ($created) {
                $notify = storeNotify('Knowledge base');
            }else{
                $notify = errorNotify('Knowledge base update');
        }

        return redirect()->back()->with($notify);
    }

    public function edit($id)
    {
        $kb = KnowledgeBase::find($id);
        $departments = Department::all();

        return view('kb.edit', compact('kb','departments'));
    }

    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'department' => 'required',
            'title' => 'required',
            'content' => 'required',
        ]);

        $department = $request->department;
        $title = $request->title;
        $content = clean($request->content);
        $status = $request->status;

        $kb = KnowledgeBase::find($id);
        $kb->department_id = $department;
        $kb->title = $title;
        $kb->content = $content;
        $kb->status = $status;

        if ($kb->save()) {
            $notify = updateNotify('Knowledge base');
        }else{
            $notify = errorNotify('Knowledge base update');
        }

        return redirect()->route('knowledge-base.index')->with($notify);
    }

    public function destroy($id)
    {
        $done = KnowledgeBase::where('id',$id)->delete();
        if ($done){
            return response()->json(['success'=>'Deleted successfully']);
        }
        return response()->json(['error'=>'Failed to delete!']);
    }

    public function KnowledgeBaseIndex()
    {
        $catgegories = Department::all();

        $posts = KnowledgeBase::latest()->where('status',KnowledgeBase::PUBLISHED)->limit('10')->get();

        return view('department', compact('catgegories','posts'));
    }

    public function viewArticle($id)
    {
        $postKey = 'post_' . $id;

        // Check if blog session key exists
        // If not, update view_count and create session key
        if (!Session::has($postKey)) {
            KnowledgeBase::where('id', $id)->increment('view_count');
            Session::put($postKey, 1);
        }
        
        $post = KnowledgeBase::with('user')->withCount('satisfiedVote','disSatisfiedVote')->where('status',KnowledgeBase::PUBLISHED)->findOrFail($id);
        
        return view('view', compact('post'));
    }

    public function categoryPost(Department $category)
    {
        $posts = KnowledgeBase::latest()->where('status',KnowledgeBase::PUBLISHED)->where('department_id', $category->id)->paginate(15);
        
        return view('departmentView', compact('posts','category'));
    }

    public function searchArticles(Request $request)
    {
        $search = $request->search;

        $posts = KnowledgeBase::latest()->where('status',KnowledgeBase::PUBLISHED)->where('title', 'LIKE',"%$search%")->paginate(15);

        $view = view('search',compact('posts','search'))->render();

        return response()->json(['posts' => $view]);
    }

    public function pinnedArticle($id)
    {
        $kb = KnowledgeBase::find($id);
        if ($kb->pinned == 1) {
            $kb->update([
                'pinned' => 0
            ]);
        }else{
            $kb->update([
                'pinned' => 1
            ]);
        }
        
        return response()->json(['success' => 'success'], 200);

    }
}
