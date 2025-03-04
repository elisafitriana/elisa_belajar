<?php

namespace App\Http\Controllers;

use App\Exports\TicketExport;
use App\Mail\TicketClose;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\ExampleMail;
use App\Mail\TicketNotification;
use Carbon\Carbon;

class TicketController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $auth = auth()->user();
        // dd($auth->id);
        $role = strtolower($auth->role);

        if($request->ajax){

            if($role == 'user'){
            $query = Ticket::with('categories')
                            ->select('tickets.*','users.name', 'units.nama_unit')
                            ->leftJoin('users', 'users.id','tickets.user_id')
                            ->leftJoin('units', 'units.id','users.id_unit')
                            ->where('tickets.user_id', $auth->id);
            }else{
                $query = Ticket::with('categories')
                            ->select('tickets.*','users.name', 'units.nama_unit')
                            ->leftJoin('users', 'users.id','tickets.user_id')
                            ->leftJoin('units', 'units.id','users.id_unit');
            }
        // dd($query);

            return datatables()->of($query)
                                ->addColumn('categories', function($data) {
                                    return implode(', ', $data->categories->pluck('name')->toArray());
                                })
                                ->addColumn('file', function($data){
                                    return "<a target='_blank' href='".Storage::url($data->file)."'>Show</a>";
                                })
                                ->escapeColumns([])
                                ->addIndexColumn()->toJson();
        }

        return view('ticket.index');
    }

    public function report(Request $request)
    {
        $request['month'] = $request->month ?? date('Y-m');
        $param = explode('-', $request->month);
        // dd($param);

        $query = Ticket::with('categories')
        ->select(
            'tickets.*',
            // 'tickets.title as title',
            // 'tickets.description as description',
            // 'tickets.status as status',
            // 'tickets.priority as priority',
            'users.name'
        )
        ->leftJoin('users', 'users.id','tickets.user_id')
        ->whereMonth('tickets.created_at', $param[1])
        ->whereYear('tickets.created_at', $param[0]);

            // dd($query->get());
        if($request->export){
            return Excel::download(new TicketExport($query->get(), $param[1]), 'ticket_report_'.$request->month.'.xlsx');
        }

        if($request->ajax){

            return datatables()->of($query)
                                ->addColumn('categories', function($data) {
                                    return implode(', ', $data->categories->pluck('name')->toArray());
                                })
                                ->addColumn('file', function($data){
                                    return "<a target='_blank' href='".Storage::url($data->file)."'>Show</a>";
                                })
                                ->escapeColumns([])
                                ->addIndexColumn()->toJson();
        }
        $report = Ticket::selectRaw("count(id) total, status")
                        ->groupBy('status')
                        ->whereMonth('tickets.created_at', $param[1])
                        ->whereYear('tickets.created_at', $param[0])
                        ->get()->groupBy('status');

        return view('ticket.report', [
            'month' =>$request->month,
            'report'=>$report
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ticket.create', [
            'categories'=>Category::select('id','name')->get(),
            'unit'=>Unit::select('id','nama_unit','kode_unit')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fileName='';
        $validated = $request->validate([
            'title' => 'required|max:100',
            'description'=>'nullable',
            'priority' => 'required',
            'file_upload' => 'nullable|image',
            'categories'=> 'required|array',
            'id_unit'=> 'required',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
        ]);
        // dd($request->all());
        $now = Carbon::now()->format('Y-m-d');
        $validated['start_date'] = $now;

        $validated['user_id'] = auth()->id();
        // dd($validated);
        if($request->hasFile('file_upload')){
            $image = '';
            // dd('true');
            // dd($request->file('file_upload'));
            // $file = $request->file('file_upload');
            // $filePath = $file->store('images','public/files');
            // $fileName = basename($filePath);
            // $filename = time() . '.' . $request->file('file_upload')->getClientOriginalExtension();
            // dd($filename);

            $file = $request->file('file_upload');

            if ($file) {
                $imgDir = public_path('images/');
                if (!is_dir($imgDir)) {
                    mkdir($imgDir, 0755, true);
                }

                $file_name = rand() . $file->getClientOriginalName();
                $file->move('images/', $file_name);
                $image = "images/" . $file_name;
            }
            $validated['file'] = $image;
        }else{
            $validated['file'] = null;
        }
        unset($validated['file_upload']);

        DB::transaction(function() use($validated, $request){
            $categoris = $validated['categories'];
            unset($validated['categories']);

            $ticket  = Ticket::create($validated);
            $insert=[];
            foreach($categoris as $cat){
                $insert[]= [
                    'category_id'=> $cat,
                    'ticket_id'   => $ticket->id,
                    'created_at'=> now()->toDateTimeString(),
                ];
            }

            TicketCategory::insert($insert);

            $users = User::where('id_unit', $validated['id_unit'])
                    ->where('role', 'admin')
                    ->get();

            $validated['description'] = strip_tags($validated['description']);
            // foreach ($users as $user) {
            //     Mail::to($user->email)->send(new TicketNotification($user, $validated));
            // }
        });

        return redirect(route('ticket.index'))->with([
            "success"=>"succesfull create ticket!"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('ticket.show', [
            'ticket'=>Ticket::with('categories','comments')->find($id)
        ]);
    }

    public function status(Request $request, $id)
    {
        $now = Carbon::now()->format('Y-m-d');
        $ticket = Ticket::find($id);

        $ticket->update([
            'status'=>$request->status
        ]);

        if($request->status == 'close')
        {
            $ticket->update([
                'end_date'=>$now
            ]);
        }

        // if($request->status=='close'){
        //     Mail::to(User::find($ticket->user_id))->send(new TicketClose($ticket));
        // }

        return redirect(route('ticket.show',$ticket->id))->with([
            "success"=>"succesfull update status!"
        ]);
    }

    public function comment(Request $request, $id)
    {
        $validated = $request->validate([
            'comment'=>'required|max:100'
        ]);
        $validated['user_id'] = auth()->id();
        $validated['ticket_id'] = $id;

        Comment::create($validated);

        return redirect(route('ticket.show',$id))->with([
            "success"=>"succesfull add comment!"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('ticket.edit', [
            'ticket'=>Ticket::with('categories')->find($id),
            'categories'=>Category::select('id','name')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:100',
            'description'=>'nullable',
            'priority' => 'required',
            'file_upload' => 'nullable|image',
            'categories'=> 'required|array',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
        ]);

        $ticket = Ticket::find($id);

        if($request->hasFile('file_upload')){
            $image = '';

            $file = $request->file('file_upload');

            if ($file) {
                $imgDir = public_path('images/');
                if (!is_dir($imgDir)) {
                    mkdir($imgDir, 0755, true);
                }

                $file_name = rand() . $file->getClientOriginalName();
                $file->move('images/', $file_name);
                $image = "images/" . $file_name;
            }
            $validated['file'] = $image;
        }else{
            // $validated['file'] = $ticket->file;
        }
        unset($validated['file_upload']);

        DB::transaction(function() use($validated, $ticket){
            $categoris = $validated['categories'];
            unset($validated['categories']);

            $ticket->update($validated);
            TicketCategory::where('ticket_id', $ticket->id)->delete();
            $insert=[];
            foreach($categoris as $cat){
                $insert[]= [
                    'category_id'=> $cat,
                    'ticket_id'   => $ticket->id,
                    'created_at'=> now()->toDateTimeString(),
                ];
            }
            TicketCategory::insert($insert);
        });

        return redirect(route('ticket.index'))->with([
            "success"=>"succesfull update ticket!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ticket::find($id)->delete();

        return redirect(route('ticket.index'))->with([
            "success"=>"succesfull delete ticket!"
        ]);
    }

    public function sendEmail()
{
    $details = [
        'title' => 'Mail from Laravel 9',
        'body' => 'This is for testing email using Mailtrap in Laravel 9.'
    ];

    Mail::to('kamaludin9951@gmail.com')->send(new ExampleMail($details));

    return 'Email sent successfully!';
}
}
