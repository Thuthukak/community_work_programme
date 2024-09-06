<?php

namespace App\Http\Controllers\CRM\Department;

use App\Helpers\Permissions;
use App\Http\Controllers\Controller;
use App\Models\CRM\Departments\Department;
use App\Models\CRM\Ticket\KnowledgeBase;
use App\Models\CRM\Ticket\Ticket;
use Illuminate\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DepartmentsController extends Controller
{
    public function permissionCheck()
    {
        $permission = new Permissions;
        return $permission;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();

        return view('departments.index', compact('departments'));
    }

    public function getDepartmentData(Request $request)
    {
        $data = Department::query();

        return DataTables::of($data)
            ->addColumn('total_tickets', function ($data){
                $ticketRoute = route('departmentTickets', $data->id);
                return '<a href="'.$ticketRoute.'">'.$data->tickets->count().'</a>';
            })->addColumn('total_kb', function ($data){
                $kbRoute = route('Knowledge.categoryPost', $data->id);
                return '<a href="'.$kbRoute.'" target="_blank">'.$data->knowledgeBase->count().'</a>';
            })
            ->addColumn('action', function ($data) {

                $value = '<button type="button" class="btn btn-primary btn-sm" id="getEditDepartmentData" data-id="'.$data->id.'" title="Edit"><i class="fa fa-edit"></i></button>
                           <button type="button" data-id="'.$data->id.'" data-toggle="modal" data-target="#DeleteProductModal" class="btn btn-danger btn-sm" id="getDeleteId" title="Delete"><i class="la la-trash-o"></i></button>
                        ';

                return $value;
            })
            ->rawColumns(['total_tickets','total_kb','ticket_title','action','ticket_status'])->make(true);
    }

    public function departmentTickets(Request $request,$id)
    {
        $user = Auth::user();
        $tickets = Ticket::with('department')->where('department_id', $id)->paginate(15);

        if ($request->ajax()){
            if (($request->has('startDate')) && ($request->has('endDate'))) {
                $data = Ticket::with('department')->where('department_id', $id)->whereBetween(DB::raw('DATE(created_at)'), [$request->startDate, $request->endDate]);
            }else{
                $data = Ticket::with('department')->where('department_id', $id);
            }

            return Datatables::of($data)
                ->addColumn('ticket_title', function ($data) {
                    $ticketRoute = route('ticket.show', $data->ticket_id);
                    $val = '<a href="' . $ticketRoute . '">'.$data->title.'</a>';
                    return $val;
                })
                ->addColumn('department', function ($data) {
                    return $data->department->title;
                })
                ->addColumn('user_name', function ($data) {
                    return optional($data->user)->name;
                })
                ->addColumn('ticket_status', function ($data) {
                    if ($data->status === "Open") {
                        $statusValue = '<span class="badge badge-warning">'.$data->status.'</span>';
                    } else {
                        $statusValue = '<span class="badge badge-success">'.$data->status.'</span>';
                    }
                    return $statusValue;
                })
                ->addColumn('updated', function ($data) {
                    return $data->updated_at->format('Y m d, h:i A');
                })
                ->addColumn('action', function ($data) use($user) {
                    $closeRoute = route('close_ticket.close', $data->ticket_id);
                    $viewRoute = route('ticket.show', $data->ticket_id);
                    $reopenRoute = route('ticketReOpen', $data->ticket_id);
                    $assign = '';
                    $reopen = '';
                    if ($user->is_admin){
                        $assign = '<button type="button" class="badge bg-info pointer" id="getAssignedTicketData" data-id="'.$data->id.'" title="Re-Assign Department">'.__('theme.reassign').'</button>';
                        $reopen = '<form action="' . $reopenRoute . '" method="post" id="reopen_form_' . $data->id . '">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <button title="Reopen Ticket" type="submit"  class="badge bg-red pointer" data-id="reopen_form_' . $data->id . '">'.__("theme.reopen").'</button>
                                </form>';
                    }

                    if ($data->status === "Open") {
                        $value = '<a href="' . $viewRoute . '"
                                   class="badge bg-primary text-white" title="Reply">'.__("theme.reply").'</a>
                               <form action="' . $closeRoute . '" method="post" id="close_form_' . $data->id . '">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <button title="Close" type="submit"  class="badge bg-red pointer" data-id="close_form_' . $data->id . '">'.__("theme.close").'</button>
                            </form>
                            '.$assign;
                    } else {
                        $value = $reopen;
                    }

                    return $value;
                })
                ->rawColumns(['ticket_title','action','ticket_status'])->make(true);
        }
        
        return view('departments.departmenttcickets', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required',
            'description'     => 'required',
        ]);

        $ticket = new Department([
            'title'     => $request->input('title'),
            'description'   => $request->input('description'),
        ]);

        if ($ticket->save()) {
            $notify = storeNotify('New department added');
        }else{
            $notify = errorNotify('Department add');
        }

        return redirect()->back()->with($notify);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $department = Department::find($id);
        $html = view('departments.modal-field', compact('department'))->render();

        return response()->json(['html'=>$html]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'title'     => 'required',
            'description'     => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $department = Department::find($id);
        $department->title = $request->title;
        $department->description = $request->description;
        $department->save();

        return response()->json(['success'=>'Ticket assigned successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = Department::find($id);

        $used = Ticket::where('department_id', $department->id)->count();
        $usekb = KnowledgeBase::where('department_id', $department->id)->count();

        if($used == 0 && $usekb == 0){
            $department->delete();

            //$notify = deleteNotify('Knowledge base');
            return response()->json(['success'=>'Deleted successfully']);
            
        } else {
            return response()->json(['error'=>'This department is used, you can\'t delete this.']);
            //$notify = errorNotify("This department is used, you can't delete this.");
        }

        return redirect()->back()->with($notify);
    }
}
