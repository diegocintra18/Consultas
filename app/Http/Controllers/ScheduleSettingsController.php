<?php

namespace App\Http\Controllers;

use App\Http\Requests\storeUpdateSettings;
use App\Models\Available;
use App\Models\Schedule_disponibility;
use App\Models\Schedule_settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\VarDumper\Dumper;
use ScheduleDisponibility;
use SebastianBergmann\CodeCoverage\Driver\Xdebug2Driver;
use stdClass;

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
        ->join("schedule_disponibility", "schedule_disponibility.schedule_settings_id", "=", "schedule_settings.id")
        ->where("schedule_settings.user_id", $user)
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

        $this->scheduleValidation($request);

        $data = $request->all();

        $days = $this->daysOfWeek($data);

        $createSettings = Schedule_settings::create([
            'schedule_duration_limit' => (integer) $data["schedule_duration_limit"],
            'schedule_before_break'   => (integer) $data["schedule_before_break"],
            'schedule_after_break'    => (integer) $data["schedule_after_break"],
            'schedule_day_start'      => $data["schedule_day_start"],
            'schedule_lunch_start'    => $data["schedule_lunch_start"],
            'schedule_lunch_end'      => $data["schedule_lunch_end"],
            'schedule_day_end'        => $data["schedule_day_end"],
            'user_id'                 => (integer) $data["users_id"]
        ]);

        $idSettings = json_decode($createSettings, TRUE);

        Schedule_disponibility::create([
            'schedule_sunday'           => $days["sunday"],
            'schedule_monday'           => $days["monday"],
            'schedule_tuesday'          => $days["tuesday"],
            'schedule_wednesday'        => $days["wednesday"],
            'schedule_thursday'         => $days["thursday"],
            'schedule_friday'           => $days["friday"],
            'schedule_saturday'         => $days["saturday"],
            'schedule_settings_id'      => $idSettings["id"]
        ]);

        //Criando um objeto para ser usado em uma função de criar faixas de horário
        $timeObj = new stdClass();

        $timeObj->dayStart = $data["schedule_day_start"];
        $timeObj->lunchStart = $data["schedule_lunch_start"];
        $timeObj->lucnhEnd = $data["schedule_lunch_end"];
        $timeObj->dayEnd = $data["schedule_day_end"];
        $timeObj->duration = $data["schedule_duration_limit"];
        $timeObj->beforeBreak = $data["schedule_before_break"];
        $timeObj->afterBreak = $data["schedule_after_break"];
        $timeObj->settings = $idSettings["id"];

        $this->AvailableTimes($timeObj);

        return redirect()->route('schedule.index')->with('message', 'As configurações foram salvas com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule_settings  $schedule_settings
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user()->id;

        $data = Schedule_settings::select(
            "schedule_settings.id",
            "schedule_settings.schedule_day_start",
            "schedule_settings.schedule_lunch_start",
            "schedule_settings.schedule_lunch_end",
            "schedule_settings.schedule_day_end",
            "schedule_settings.schedule_duration_limit",
            "schedule_settings.schedule_before_break",
            "schedule_settings.schedule_after_break",
            "schedule_disponibility.schedule_sunday",
            "schedule_disponibility.schedule_monday",
            "schedule_disponibility.schedule_tuesday",
            "schedule_disponibility.schedule_wednesday",
            "schedule_disponibility.schedule_thursday",
            "schedule_disponibility.schedule_friday",
            "schedule_disponibility.schedule_saturday"
        )
        ->join("schedule_disponibility", "schedule_disponibility.id", "=", "schedule_settings.id")
        ->where("schedule_settings.user_id", $user)
        ->where("schedule_settings.id", $id)
        ->get();

        if ( isset($data) == true  ) {
            $data = json_decode($data, TRUE);
            $schedule_settings = $data[0];
            return view('config/schedule-config', compact('schedule_settings'));
        } else {
            return view('config/schedule-config');
        }
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
    public function update(storeUpdateSettings $request)
    {
        $this->scheduleValidation($request);

        $data = $request->all();

        $days = $this->daysOfWeek($data);

        $updateSettings = Schedule_settings::where('id', $data["id"])
            ->update([
            'schedule_duration_limit' => (integer) $data["schedule_duration_limit"],
            'schedule_before_break'   => (integer) $data["schedule_before_break"],
            'schedule_after_break'    => (integer) $data["schedule_after_break"],
            'schedule_day_start'      => $data["schedule_day_start"],
            'schedule_lunch_start'    => $data["schedule_lunch_start"],
            'schedule_lunch_end'      => $data["schedule_lunch_end"],
            'schedule_day_end'        => $data["schedule_day_end"]
        ]);

        Schedule_disponibility::where('id', $data["id"])
            ->update([
            'schedule_sunday'           => $days["sunday"],
            'schedule_monday'           => $days["monday"],
            'schedule_tuesday'          => $days["tuesday"],
            'schedule_wednesday'        => $days["wednesday"],
            'schedule_thursday'         => $days["thursday"],
            'schedule_friday'           => $days["friday"],
            'schedule_saturday'         => $days["saturday"],
        ]);

        //Criando um objeto para ser usado em uma função de criar faixas de horário
        $timeObj = new stdClass();

        $timeObj->dayStart = $data["schedule_day_start"];
        $timeObj->lunchStart = $data["schedule_lunch_start"];
        $timeObj->lucnhEnd = $data["schedule_lunch_end"];
        $timeObj->dayEnd = $data["schedule_day_end"];
        $timeObj->duration = $data["schedule_duration_limit"];
        $timeObj->beforeBreak = $data["schedule_before_break"];
        $timeObj->afterBreak = $data["schedule_after_break"];
        $timeObj->settings = $data["id"];

        $available = Available::where("schedule_settings_id", $data["id"])->delete();

        $this->AvailableTimes($timeObj);

        return redirect()->route('schedule.index')->with('message', 'As configurações foram salvas com sucesso!');
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
        $available = Available::where("schedule_settings_id", $id)->delete();
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

    function scheduleValidation($request){
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

        return true;
    }

    public function AvailableTimes(stdClass $timeObj){
        //Calculando quantas consultas podem ser realizadas em um dia
        $durationAndBreak = $timeObj->duration + $timeObj->beforeBreak + $timeObj->afterBreak;
        $timeObj->break = $timeObj->beforeBreak + $timeObj->afterBreak;
        $disponibilityMorning = strtotime($timeObj->lunchStart) - strtotime($timeObj->dayStart);
        $disponibilityAfternoon = strtotime($timeObj->dayEnd) - strtotime($timeObj->lucnhEnd);
        $timeMorning = ($disponibilityMorning/60) / $durationAndBreak;
        $timeAfternoon = ($disponibilityAfternoon/60) / $durationAndBreak;

        function convertHoras($horasInteiras) {

            // Define o formato de saida
            $formato = '%02d:%02d';
            // Converte para minutos
            $minutos = $horasInteiras;

            // Converte para o formato hora
            $horas = floor($minutos / 60);
            $minutos = ($minutos % 60);

            // Retorna o valor
            return sprintf($formato, $horas, $minutos);
        }

        function scheduleTimeMorning(stdClass $timeObj, $time, $id){
            // Este for cria todas as faixas de horário seguindo as regras cadastradas
            for($i = 0; $i < $time; $i++){
                
                if ($i == 0){
                    $timeObj->scheduleEnd = strtotime($timeObj->dayStart) + strtotime(convertHoras($timeObj->duration));
                    $timeObj->nextSchedule = $timeObj->scheduleEnd + strtotime(convertHoras($timeObj->break));
                    $timeObj->nextScheduleEnd = $timeObj->nextSchedule + strtotime(convertHoras($timeObj->duration));
                    
                    $available[0]['available_start'] = $timeObj->dayStart;
                    $available[0]['available_end'] = date('H:i',$timeObj->scheduleEnd);
                    $available[$i+1]['available_start'] = date('H:i',$timeObj->nextSchedule);
                    $available[$i+1]['available_end'] = date('H:i',$timeObj->nextScheduleEnd);
                } else {
                    $timeObj->nextSchedule = $timeObj->nextScheduleEnd + strtotime(convertHoras($timeObj->break));
                    $timeObj->nextScheduleEnd = $timeObj->nextSchedule + strtotime(convertHoras($timeObj->duration));

                    $a = date('H:i',$timeObj->nextScheduleEnd);
                    $b = date('H:i',strtotime($timeObj->lunchStart));

                    if ( $a < $b ) {

                        $available[$i+1]['available_start'] = date('H:i',$timeObj->nextSchedule);
                        $available[$i+1]['available_end'] = date('H:i',$timeObj->nextScheduleEnd);
                    }
                    
                }
            }
            
            foreach($available as $a){
                Available::create([
                    'available_start' => $a['available_start'],
                    'available_end' => $a['available_end'],
                    'schedule_settings_id' => $id
                ]);
            }
            
        }

        function scheduleTimeAfternoon(stdClass $timeObj, $time, $id){
            // Este for cria todas as faixas de horário seguindo as regras cadastradas
            for($i = 0; $i < $time; $i++){
                
                if ($i == 0){
                    $timeObj->scheduleEnd = strtotime($timeObj->lucnhEnd) + strtotime(convertHoras($timeObj->duration));
                    $timeObj->nextSchedule = $timeObj->scheduleEnd + strtotime(convertHoras($timeObj->break));
                    $timeObj->nextScheduleEnd = $timeObj->nextSchedule + strtotime(convertHoras($timeObj->duration));
                    
                    $available[0]['available_start'] = $timeObj->lucnhEnd;
                    $available[0]['available_end'] = date('H:i',$timeObj->scheduleEnd);
                    $available[$i+1]['available_start'] = date('H:i',$timeObj->nextSchedule);
                    $available[$i+1]['available_end'] = date('H:i',$timeObj->nextScheduleEnd);

                } else {
                    $timeObj->nextSchedule = $timeObj->nextScheduleEnd + strtotime(convertHoras($timeObj->break));
                    $timeObj->nextScheduleEnd = $timeObj->nextSchedule + strtotime(convertHoras($timeObj->duration));

                    $a = date('H:i',$timeObj->nextScheduleEnd);
                    $b = date('H:i',strtotime($timeObj->dayEnd));

                    if ( $a < $b ) {
                        $available[$i+1]['available_start'] = date('H:i',$timeObj->nextSchedule);
                        $available[$i+1]['available_end'] = date('H:i',$timeObj->nextScheduleEnd);
                    }
                    
                }
            }
            
            foreach($available as $a){
                Available::create([
                    'available_start' => $a['available_start'],
                    'available_end' => $a['available_end'],
                    'schedule_settings_id' => $id
                ]);
            }
        }

        //Estas chamadas salvam as faixas de horário disponíveis no banco
        scheduleTimeMorning($timeObj, (integer) $timeMorning, $timeObj->settings);
        scheduleTimeAfternoon($timeObj, (integer) $timeAfternoon, $timeObj->settings);
    }

}
