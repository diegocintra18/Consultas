<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeUpdateSettings;
use App\Models\Schedule_disponibility;
use App\Models\Schedule_settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\VarDumper\Dumper;
use ScheduleDisponibility;

class ScheduleSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // esta função verifica se existem regras de agendamento criadas, caso existam elas serão exibidas,
        // caso não, a rota será chamada para a construção da página em branco;
        $user = Auth::user()->id;

        $data = Schedule_settings::select(
            "schedule_settings.id",
            "schedule_settings.schedule_day_start",
            "schedule_settings.schedule_day_start",
            "schedule_settings.schedule_lunch_start",
            "schedule_settings.schedule_lunch_end",
            "schedule_settings.schedule_day_end",
            "schedule_settings.schedule_duration_limit",
            "schedule_disponibility.schedule_sunday",
            "schedule_disponibility.schedule_monday",
            "schedule_disponibility.schedule_tuesday",
            "schedule_disponibility.schedule_wednesday",
            "schedule_disponibility.schedule_thursday",
            "schedule_disponibility.schedule_friday",
            "schedule_disponibility.schedule_saturday"
        )
        ->join("schedule_disponibility", "schedule_disponibility.id", "=", "schedule_settings.id")
        ->get();

        if ( isset($data) == true  ) {
            $schedule_settings = json_decode($data, TRUE);
            return view('config/add-schedule-config', compact('schedule_settings'));
        } else {
            return view('config/add-schedule-config');
        }
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

        $days = $this->daysOfWeek($data);

        $createSettings = Schedule_settings::create([
            'schedule_id'             => (integer) $data["users_id"],
            'schedule_duration_limit' => (integer) $data["schedule_duration_limit"],
            'schedule_before_break'   => (integer) $data["schedule_before_break"],
            'schedule_after_break'    => (integer) $data["schedule_after_break"],
            'schedule_day_start'      => $data["schedule_day_start"],
            'schedule_lunch_start'    => $data["schedule_lunch_start"],
            'schedule_lunch_end'      => $data["schedule_lunch_end"],
            'schedule_day_end'        => $data["schedule_day_end"],
            'user_id'                => (integer) $data["users_id"]
        ]);

        $idSettings = json_decode($createSettings, TRUE);

        Schedule_disponibility::create([
            'schedule_disponibility_id' => $idSettings["id"],
            'schedule_sunday'           => $days["sunday"],
            'schedule_monday'           => $days["monday"],
            'schedule_tuesday'          => $days["tuesday"],
            'schedule_wednesday'        => $days["wednesday"],
            'schedule_thursday'         => $days["thursday"],
            'schedule_friday'           => $days["friday"],
            'schedule_saturday'         => $days["saturday"],
            'schedule_settings_id'      => $idSettings["id"]
        ]);

        return redirect()->route('schedule.index')->with('message', 'As configurações foram salvas com sucesso!');
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
    public function destroy($id)
    {
        $disponibility = Schedule_disponibility::where("schedule_settings_id", $id)->delete();
        $settings = Schedule_settings::where("id", $id)->delete();
        

        return redirect()->route('schedule.index')->with('message', 'Configurações excluídas com sucesso!');
    }

    function daysOfWeek($data){

        /*Esta função recebe o array de preenchimento do formulário, e verifica quais dias da semana foram
        preenchidos para popular um array
        */

        if( array_key_exists("schedule_sunday", $data) ){
            $days["sunday"] = 1;
        } else {
            $days["sunday"] = 0;
        }

        if( array_key_exists("schedule_monday", $data) ){
            $days["monday"] = 1;
        } else {
            $days["monday"] = 0;
        }

        if( array_key_exists("schedule_tuesday", $data) ){
            $days["tuesday"] = 1;
        } else {
            $days["tuesday"] = 0;
        }

        if( array_key_exists("schedule_wednesday", $data) ){
            $days["wednesday"] = 1;
        } else {
            $days["wednesday"] = 0;
        }

        if( array_key_exists("schedule_thursday", $data) ){
            $days["thursday"] = 1;
        } else {
            $days["thursday"] = 0;
        }

        if( array_key_exists("schedule_friday", $data) ){
            $days["friday"] = 1;
        } else {
            $days["friday"] = 0;
        }

        if( array_key_exists("schedule_saturday", $data) ){
            $days["saturday"] = 1;
        } else {
            $days["saturday"] = 0;
        }

        return $days;
        
    }

}
