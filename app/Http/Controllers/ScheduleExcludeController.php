<?php

namespace App\Http\Controllers;

use App\Models\Schedule_exclude;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleExcludeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->id;

        $data = Schedule_exclude::select(
            "id",
            "exclude_date"
        )
        ->where("user_id", $user)
        ->orderBy("exclude_date")
        ->get();

        if ( isset($data) == true  ) {
            $exclude = json_decode($data, TRUE);
            return view('config.schedule-exclude', compact('exclude'));
        } else {
            return view('config.schedule-exclude');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $today = date("Y-m-d");
        
        if ($data['schedule_exclude_date'] >= $today){
            $id = Auth::user()->id;
            Schedule_exclude::create([
                "exclude_date" => $data['schedule_exclude_date'],
                "user_id" => $id
            ]);

            return redirect()->back()->with('message', 'Data de bloqueio cadastrada com sucesso!');

        } else {
            return redirect()->back()->with('error', 'Não é possível cadastrar uma data de exclusão no passado!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Schedule_exclude::where("id", $id)->delete();
        
        return redirect()->route('scheduleexclude.index')->with('message', 'Configurações excluídas com sucesso!');
    }
}
