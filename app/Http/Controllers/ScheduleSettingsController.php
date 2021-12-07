<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeUpdateSettings;
use App\Models\Schedule_settings;
use Illuminate\Http\Request;
use Psy\VarDumper\Dumper;

class ScheduleSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('config/schedule-config');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(storeUpdateSettings $request)
    {
        
        $horaEntrada = strtotime($request->input('schedule_day_start'));
        $saidaAlmoco =  strtotime($request->input('schedule_lunch_start'));
        $retornoAlmoco = strtotime($request->input('schedule_lunch_end'));
        $horaSaida = strtotime($request->input('schedule_day_end'));

        if ( $horaEntrada >= $saidaAlmoco ) {
            return redirect()->back()->with('error', "O horário de almoço não pode ser menor que o horário de entrada");
        }
        if ( $saidaAlmoco >= $retornoAlmoco ) {
            return redirect()->back()->with('error', "O horário de saída do almoço não pode ser menor que o horário de retorno");
        }
        if ( $retornoAlmoco >= $horaSaida ) {
            return redirect()->back()->with('error', "O horário de retorno do almoço não pode ser maior que o horário de final do expediente");
        }

        $data = $request->all();

        

        return redirect()->back()->with('success', "As configurações foram salvas com sucesso!");
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule_settings  $schedule_settings
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule_settings $schedule_settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule_settings  $schedule_settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule_settings $schedule_settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule_settings  $schedule_settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule_settings $schedule_settings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule_settings  $schedule_settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule_settings $schedule_settings)
    {
        //
    }

}
